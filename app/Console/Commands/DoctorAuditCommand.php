<?php

namespace App\Console\Commands;

use App\Services\DoctorAuditService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Non-destructive replacement for the deprecated `doctor:sync-source`.
 *
 * At Gate A this command is READ-ONLY: there is no --execute path, and it
 * cannot modify a doctor, a schedule, or a file. It compares the source
 * workbooks, the photo folder and the database, and writes a report describing
 * what a later correction step would change.
 *
 * The write flags (--fix-contacts, --fix-images, --sync-schedules, ...) are
 * added in later gates, each gated on an explicit approval.
 */
class DoctorAuditCommand extends Command
{
    protected $signature = 'doctor:audit
        {--source= : Directory containing doctors.xlsx, the schedule workbooks and images/}
        {--report-only : Explicit no-op flag; the command is read-only regardless}
        {--doctor= : Restrict the doctor sections to one doctor id or name fragment}
        {--branch= : Restrict the schedule sections to one branch token, e.g. hatirpool}
        {--workbook= : Restrict the schedule sections to one workbook filename}
        {--json : Also print the raw result as JSON}';

    protected $description = 'Audit doctor records, schedules and photos against the source workbooks (read-only)';

    public function handle(DoctorAuditService $audit): int
    {
        $sourceDir = $this->option('source') ?: config('doctor_sync.sources.default_directory');

        if (! $sourceDir) {
            $this->error('No source directory. Pass --source="<path>" or set DOCTOR_SOURCE_DIR in .env');

            return self::FAILURE;
        }

        $this->info('Doctor audit - READ ONLY. No record, file or workbook will be modified.');
        $this->line('Source: '.$sourceDir);
        $this->newLine();

        try {
            $result = $audit->audit($sourceDir);
        } catch (\Throwable $e) {
            $this->error('Audit failed: '.$e->getMessage());

            return self::FAILURE;
        }

        $result = $this->applyFilters($result);

        $directory = $this->writeArtifacts($result);

        $this->renderSummary($result);

        $this->newLine();
        $this->info('Report written to: '.$directory);
        $this->line('Nothing was changed. Corrections require a later, separately approved gate.');

        if ($this->option('json')) {
            $this->line(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        return self::SUCCESS;
    }

    /**
     * Apply the optional --doctor / --branch / --workbook narrowing.
     */
    protected function applyFilters(array $result): array
    {
        if ($doctor = $this->option('doctor')) {
            $needle = mb_strtolower((string) $doctor);

            $matches = function (array $row) use ($needle) {
                return (string) ($row['doctor_id'] ?? '') === $needle
                    || str_contains(mb_strtolower((string) ($row['doctor_name'] ?? $row['name'] ?? '')), $needle);
            };

            foreach (['doctors', 'schedules', 'conflicts', 'fillable_blanks', 'gender_needed', 'fees_needed'] as $key) {
                $result[$key] = array_values(array_filter($result[$key] ?? [], $matches));
            }
        }

        if ($branch = $this->option('branch')) {
            $token = mb_strtolower((string) $branch);
            $result['schedules'] = array_values(array_filter(
                $result['schedules'] ?? [],
                fn ($row) => str_contains(mb_strtolower((string) ($row['branch_token'] ?? '')), $token)
            ));
        }

        if ($workbook = $this->option('workbook')) {
            $needle = mb_strtolower((string) $workbook);
            $result['schedules'] = array_values(array_filter(
                $result['schedules'] ?? [],
                fn ($row) => str_contains(mb_strtolower((string) ($row['source'] ?? '')), $needle)
            ));
        }

        return $result;
    }

    /**
     * Print the headline numbers an operator needs before reading the report.
     */
    protected function renderSummary(array $result): void
    {
        $counts = $result['counts'];

        $this->table(['Source / database', 'Count'], [
            ['Workbook profile rows', $counts['profile_rows']],
            ['Workbook schedule rows', $counts['schedule_rows']],
            ['Provided doctor photos', $counts['source_images']],
            ['Database doctors', $counts['db_doctors']],
            ['  of which soft-deleted', $counts['db_doctors_trashed']],
            ['Database branch schedules', $counts['db_schedules']],
            ['Database consultation bookings', $counts['db_bookings']],
        ]);

        $images = $result['images'];

        $this->table(['Finding', 'Count'], [
            ['Images OK', count($images['valid'])],
            ['Images BROKEN (path set, file missing)', count($images['broken'])],
            ['Images with an unsafe path', count($images['unsafe'])],
            ['Doctors with no image at all', count($images['no_image'])],
            ['Orphan files in uploads/doctors', count($images['orphan_files'])],
            ['Provided photos with no doctor', count($images['unmatched_source_photos'])],
            ['Workbook profiles with no doctor', count($result['unmatched_profiles'])],
            ['Field conflicts (never auto-written)', count($result['conflicts'])],
            ['Blank fields fillable from workbook', count($result['fillable_blanks'])],
            ['Ambiguous matches (skipped)', count($result['ambiguous'])],
            ['Doctors needing gender', count($result['gender_needed'])],
            ['Doctors needing a fee', count($result['fees_needed'])],
            ['Cross-branch schedule overlaps', count($result['cross_branch_overlaps'])],
            ['Rows skipped with a reason', count($result['skipped'])],
        ]);

        $statuses = array_count_values(array_column($result['schedules'], 'status'));
        ksort($statuses);

        $this->table(
            ['Schedule row status', 'Count'],
            array_map(fn ($status, $count) => [$status, $count], array_keys($statuses), $statuses)
        );

        if ($result['branches']['unresolved'] !== []) {
            $this->newLine();
            $this->error('Unresolved branch tokens: '.implode(', ', $result['branches']['unresolved']));
            $this->line('A branch is never guessed. Add an alias in config/doctor_sync.php.');
        }
    }

    /**
     * Write the report and its machine-readable siblings.
     */
    protected function writeArtifacts(array $result): string
    {
        $stamp = config('app.env').'-'.Carbon::now(config('app.timezone'))->format('Ymd-His');
        $directory = storage_path('app/'.config('doctor_sync.audit.output_directory', 'doctor-audit').'/'.$stamp);

        File::ensureDirectoryExists($directory);

        File::put($directory.'/audit.json', json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        File::put($directory.'/report.md', $this->buildReport($result));

        $this->writeCsv($directory.'/gender-needed.csv', $result['gender_needed']);
        $this->writeCsv($directory.'/fees-needed.csv', $result['fees_needed']);
        $this->writeCsv($directory.'/conflicts.csv', $result['conflicts']);
        $this->writeCsv($directory.'/manual-review.csv', $result['ambiguous']);
        $this->writeCsv($directory.'/schedule-diff.csv', array_map(function ($row) {
            $row['days_flags'] = implode('|', $row['days_flags'] ?? []);
            $row['time_flags'] = implode('|', $row['time_flags'] ?? []);
            unset($row['fields']);

            return $row;
        }, $result['schedules']));
        $this->writeCsv($directory.'/skipped.csv', $result['skipped']);
        $this->writeCsv($directory.'/images-before.csv', array_merge(
            array_map(fn ($r) => $r + ['category' => 'referenced'], array_merge($result['images']['valid'], $result['images']['broken'])),
            array_map(fn ($r) => $r + ['category' => 'orphan'], $result['images']['orphan_files'])
        ));

        return $directory;
    }

    /**
     * Render the human-readable report.
     */
    protected function buildReport(array $result): string
    {
        $env = $result['environment'];
        $counts = $result['counts'];
        $images = $result['images'];

        $md = [];
        $md[] = '# Doctor audit report';
        $md[] = '';
        $md[] = '> READ-ONLY RUN. No database record, file, image or workbook was modified.';
        $md[] = '';

        $md[] = '## 12. Environment';
        $md[] = '';
        foreach ($env as $key => $value) {
            $md[] = '- **'.$key.'**: '.$value;
        }
        $md[] = '';

        $md[] = '## 11. Command';
        $md[] = '';
        $md[] = '```';
        $md[] = 'php artisan '.$this->buildCommandLine();
        $md[] = '```';
        $md[] = '';

        $md[] = '## 1. Doctors (before)';
        $md[] = '';
        $md[] = 'Total: '.$counts['db_doctors'].' ('.$counts['db_doctors_trashed'].' soft-deleted)';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['id', 'name', 'status', 'specialty', 'image_status', 'profile_match', 'has_source_photo'],
            array_map(fn ($r) => [
                $r['doctor_id'], $r['name'], $r['status'], (string) $r['specialty'],
                $r['image_status'], $r['profile_match'], $r['has_source_photo'],
            ], $result['doctors'])
        );

        $md[] = '## 2. Schedules (before / proposed)';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['source', 'row', 'doctor', 'branch', 'status', 'days (db)', 'days (proposed)', 'time (db)', 'time (proposed)', 'flags'],
            array_map(fn ($r) => [
                $r['source'], $r['workbook_row'], (string) ($r['doctor_name'] ?? $r['workbook_name']),
                (string) ($r['branch_id'] ?? $r['branch_token']), $r['status'],
                (string) ($r['days_db'] ?? ''), (string) ($r['days_proposed'] ?? ''),
                (string) ($r['time_db'] ?? ''), (string) ($r['time_proposed'] ?? ''),
                implode(' ', array_merge($r['days_flags'] ?? [], $r['time_flags'] ?? [])),
            ], $result['schedules'])
        );

        $md[] = '## 3. Image paths (before)';
        $md[] = '';
        $md[] = '- OK: '.count($images['valid']);
        $md[] = '- BROKEN: '.count($images['broken']);
        $md[] = '- UNSAFE_PATH: '.count($images['unsafe']);
        $md[] = '- NO_IMAGE: '.count($images['no_image']);
        $md[] = '';
        if ($images['broken'] !== []) {
            $md[] = $this->markdownTable(
                ['id', 'name', 'stored path', 'currently renders'],
                array_map(fn ($r) => [$r['doctor_id'], $r['doctor_name'], (string) $r['image'], $r['effective_url']], $images['broken'])
            );
        }

        $md[] = '## 4. Checksums';
        $md[] = '';
        $md[] = '### Provided source photos';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['filename', 'sha256', 'bytes'],
            array_map(fn ($r) => [$r['filename'], $r['sha256'], $r['bytes']], $images['source_photo_checksums'])
        );
        $md[] = '### Stored doctor photos';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['id', 'name', 'path', 'sha256'],
            array_map(fn ($r) => [$r['doctor_id'], $r['doctor_name'], (string) $r['image'], (string) ($r['sha256'] ?? '')], $images['valid'])
        );

        $md[] = '## 5. Unmatched images';
        $md[] = '';
        $md[] = '### Orphan files in uploads/doctors (referenced by no doctor)';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['path', 'sha256', 'matches provided photo'],
            array_map(fn ($r) => [$r['path'], $r['sha256'], (string) $r['matches_source_photo']], $images['orphan_files'])
        );
        $md[] = '### Provided photos with no doctor record';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['filename', 'canonical name'],
            array_map(fn ($r) => [$r['filename'], $r['canonical']], $images['unmatched_source_photos'])
        );

        $md[] = '## 6. Doctors needing gender';
        $md[] = '';
        $md[] = 'Gender is never inferred from a name, title, photo or specialty. Until these';
        $md[] = 'are filled in by a human, every doctor without a personal photo shows the';
        $md[] = 'neutral avatar - the male/female fallback is implemented but not operational.';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['id', 'name', 'specialty', 'has personal photo', 'current gender'],
            array_map(fn ($r) => [$r['doctor_id'], $r['doctor_name'], (string) $r['specialty'], $r['has_personal_photo'], (string) $r['current_gender']], $result['gender_needed'])
        );

        $md[] = '## 7. Doctors needing a consultation fee';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['id', 'name', 'consultation fee'],
            array_map(fn ($r) => [$r['doctor_id'], $r['doctor_name'], $r['consultation_fee']], $result['fees_needed'])
        );

        $md[] = '## 8. Ambiguous matches (skipped, never guessed)';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['type', 'reference', 'reason', 'candidates'],
            array_map(fn ($r) => [
                $r['type'],
                (string) ($r['doctor_name'] ?? ($r['source'] ?? '').':'.($r['workbook_row'] ?? '')),
                $r['reason'],
                $r['candidates'],
            ], $result['ambiguous'])
        );

        $md[] = '## 9. Workbook / database conflicts';
        $md[] = '';
        $md[] = 'A non-empty database value is NEVER overwritten automatically. These rows';
        $md[] = 'need a human decision.';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['id', 'name', 'field', 'database value', 'workbook value'],
            array_map(fn ($r) => [$r['doctor_id'], $r['doctor_name'], $r['field'], (string) $r['db_value'], (string) $r['workbook_value']], $result['conflicts'])
        );

        $md[] = '### Blank fields that could be filled from the workbook';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['id', 'name', 'field', 'classification', 'proposed value'],
            array_map(fn ($r) => [$r['doctor_id'], $r['doctor_name'], $r['field'], $r['classification'], (string) $r['proposed_value']], $result['fillable_blanks'])
        );

        $md[] = '### Workbook profiles with no database record';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['workbook row', 'name', 'designation', 'has provided photo'],
            array_map(fn ($r) => [$r['workbook_row'], $r['name'], (string) $r['designation'], $r['has_source_photo']], $result['unmatched_profiles'])
        );

        $md[] = '## 10. Rows skipped, with reasons';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['area', 'reference', 'reason'],
            array_map(fn ($r) => [$r['area'], (string) $r['reference'], $r['reason']], $result['skipped'])
        );

        $md[] = '### Cross-branch schedule overlaps (reported, not blocked)';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['doctor', 'shared days', 'branch A', 'time A', 'branch B', 'time B'],
            array_map(fn ($r) => [(string) $r['doctor_name'], $r['days'], $r['branch_a'], (string) $r['time_a'], $r['branch_b'], (string) $r['time_b']], $result['cross_branch_overlaps'])
        );

        $md[] = '### Branch resolution';
        $md[] = '';
        $md[] = $this->markdownTable(
            ['workbook token', 'resolved branch id', 'branch name'],
            array_map(fn ($r) => [$r['workbook_token'], $r['branch_id'], (string) $r['branch_name']], $result['branches']['resolved'])
        );

        return implode("\n", $md)."\n";
    }

    /**
     * Reconstruct the invocation for the report's audit trail.
     */
    protected function buildCommandLine(): string
    {
        $parts = ['doctor:audit'];

        foreach (['source', 'doctor', 'branch', 'workbook'] as $option) {
            if ($value = $this->option($option)) {
                $parts[] = '--'.$option.'="'.$value.'"';
            }
        }

        foreach (['report-only', 'json'] as $flag) {
            if ($this->option($flag)) {
                $parts[] = '--'.$flag;
            }
        }

        return implode(' ', $parts);
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     */
    protected function writeCsv(string $path, array $rows): void
    {
        $handle = fopen($path, 'w');

        if ($handle === false) {
            return;
        }

        if ($rows === []) {
            fwrite($handle, "(no rows)\n");
            fclose($handle);

            return;
        }

        fputcsv($handle, array_keys($rows[0]));

        foreach ($rows as $row) {
            fputcsv($handle, array_map(
                fn ($value) => is_array($value) ? implode('|', $value) : (is_bool($value) ? ($value ? 'true' : 'false') : $value),
                $row
            ));
        }

        fclose($handle);
    }

    /**
     * @param  array<int, string>  $headers
     * @param  array<int, array<int, mixed>>  $rows
     */
    protected function markdownTable(array $headers, array $rows): string
    {
        if ($rows === []) {
            return "_None._\n";
        }

        $escape = static fn ($value) => str_replace(['|', "\n"], ['\\|', ' '], (string) $value);

        $out = '| '.implode(' | ', $headers)." |\n";
        $out .= '|'.str_repeat('---|', count($headers))."\n";

        foreach ($rows as $row) {
            $out .= '| '.implode(' | ', array_map($escape, $row))." |\n";
        }

        return $out."\n";
    }
}
