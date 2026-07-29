<?php

namespace App\Console\Commands;

use App\Services\DoctorAuditService;
use App\Services\DoctorSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Non-destructive replacement for the deprecated `doctor:sync-source`.
 *
 * The audit itself is always read-only: DoctorAuditService never writes. The
 * write flags below (--fix-images, --fix-contacts, --create-missing,
 * --fill-blanks, --propose-gender, --apply-gender, --sync-schedules,
 * --reassign-specialty) each delegate to a single DoctorSyncService method and
 * all default to a dry run - **--execute is required to persist anything**.
 * Every write is wrapped in a transaction and preceded by a snapshot that
 * `doctor:audit:rollback` can undo.
 */
class DoctorAuditCommand extends Command
{
    protected $signature = 'doctor:audit
        {--source= : Directory containing doctors.xlsx, the schedule workbooks and images/}
        {--report-only : Explicit no-op flag; the command is read-only regardless}
        {--execute : Persist the requested write operation(s). Without this, every write flag only previews}
        {--doctor= : Restrict the doctor sections to one doctor id or name fragment}
        {--branch= : Restrict the schedule sections to one branch token, e.g. hatirpool}
        {--workbook= : Restrict the schedule sections to one workbook filename}
        {--propose-gender : Write gender-assignments.csv from the curated config(\'doctor_sync.gender_map\') for review}
        {--apply-gender= : Path to a (possibly edited) gender-assignments.csv to apply}
        {--fix-images : Null out doctors.image where the stored path does not resolve to a real file}
        {--fix-contacts : Null out the known-fabricated email/phone values}
        {--create-missing : Create workbook profiles that have no database doctor (inactive, no schedule)}
        {--fill-blanks : Fill NULL/blank qualification, designation, bio, address from the workbook}
        {--sync-schedules : Apply the schedule diff (safe rows only; see report for what is skipped)}
        {--reassign-specialty : Apply the approved Dr. Md. Mahfuzur Rahman -> Oral & Maxillofacial Surgery correction}
        {--json : Also print the raw result as JSON}';

    protected $description = 'Audit doctor records, schedules and photos against the source workbooks; optionally apply approved corrections';

    public function handle(DoctorAuditService $audit, DoctorSyncService $sync): int
    {
        $sourceDir = $this->option('source') ?: config('doctor_sync.sources.default_directory');

        if (! $sourceDir) {
            $this->error('No source directory. Pass --source="<path>" or set DOCTOR_SOURCE_DIR in .env');

            return self::FAILURE;
        }

        $execute = (bool) $this->option('execute');

        $this->info($execute
            ? 'Doctor audit - EXECUTE MODE. Requested write operations will be persisted.'
            : 'Doctor audit - READ ONLY / DRY RUN. No record, file or workbook will be modified.');
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

        $this->runWriteOperations($result, $sync, $execute, $directory);

        $this->newLine();
        $this->info('Report written to: '.$directory);
        $this->line($execute
            ? 'Requested operations above were persisted (see snapshot paths for rollback).'
            : 'Nothing was changed. Pass --execute to persist a requested operation.');

        if ($this->option('json')) {
            $this->line(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }

        return self::SUCCESS;
    }

    /**
     * Run whichever write flags were passed, in a fixed, safe order:
     * gender proposal/application, then contact/image/profile cleanup, then
     * missing-doctor creation, then schedules, then the specialty
     * reassignment. Each is independently optional and independently no-ops
     * without --execute.
     */
    protected function runWriteOperations(array $result, DoctorSyncService $sync, bool $execute, string $directory): void
    {
        if ($this->option('propose-gender')) {
            $rows = $sync->proposeGender($result);
            $path = $directory.'/gender-assignments.csv';
            $this->writeCsv($path, $rows);

            $missing = collect($rows)->where('in_curated_map', 'no')->count();
            $this->newLine();
            $this->comment("Gender proposal written: {$path}");
            $this->line(count($rows)." rows, {$missing} with no curated mapping (review before applying).");
        }

        if ($csvPath = $this->option('apply-gender')) {
            $rows = $this->readCsv($csvPath);
            $outcome = $sync->applyGender($rows, $execute);

            $this->newLine();
            $this->comment('Apply gender: '.($execute ? 'EXECUTED' : 'DRY RUN'));
            $this->table(['Metric', 'Count'], [
                ['Would update / updated', $outcome['updated']],
                ['Skipped (already set)', $outcome['skipped_already_set']],
                ['Skipped (no value)', $outcome['skipped_no_value']],
            ]);
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }

        if ($this->option('fix-contacts')) {
            $outcome = $sync->fixContacts($result, $execute);
            $this->newLine();
            $this->comment('Fix contacts: '.($execute ? 'EXECUTED' : 'DRY RUN'));
            $this->line("Emails nulled: {$outcome['fixed_email']}, phones nulled: {$outcome['fixed_phone']}");
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }

        if ($this->option('fix-images')) {
            $outcome = $sync->fixImages($result, $execute);
            $this->newLine();
            $this->comment('Fix images: '.($execute ? 'EXECUTED' : 'DRY RUN'));
            $this->line("Broken paths nulled: {$outcome['fixed']}");
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }

        if ($this->option('fill-blanks')) {
            $outcome = $sync->fillBlankProfileFields($result, $execute);
            $this->newLine();
            $this->comment('Fill blank profile fields: '.($execute ? 'EXECUTED' : 'DRY RUN'));
            $this->line("Fields filled: {$outcome['filled']}");
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }

        if ($this->option('create-missing')) {
            $outcome = $sync->createMissingDoctors($result, $execute);
            $this->newLine();
            $this->comment('Create missing doctors: '.($execute ? 'EXECUTED' : 'DRY RUN'));
            foreach ($outcome['created'] as $row) {
                $this->line('  '.$row['name'].($row['id'] ? " -> id {$row['id']}" : ' -> (dry run, not created)'));
            }
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }

        if ($this->option('sync-schedules')) {
            $manual = $this->resolveManualScheduleCorrections($result);
            $this->printManualScheduleCorrections($result, $manual);

            $outcome = $sync->syncSchedules($result, $execute, $manual);
            $this->newLine();
            $this->comment('Sync schedules: '.($execute ? 'EXECUTED' : 'DRY RUN'));
            $this->table(['Metric', 'Count'], [
                ['Normalized rows applied', $outcome['applied']],
                ['Manually corrected rows applied', $outcome['corrected']],
                ['Already current (no-op)', $outcome['already_current']],
                ['Skipped (protected / ambiguous / unresolved)', $outcome['skipped']],
            ]);
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }

        if ($this->option('reassign-specialty')) {
            $outcome = $sync->reassignSpecialty(
                'md mahfuzur rahman',
                'Oral & Maxillofacial Surgery',
                'Oral & Maxillofacial Surgery',
                $result,
                $execute
            );
            $this->newLine();
            $this->comment('Reassign specialty (Dr. Md. Mahfuzur Rahman): '.($execute ? 'EXECUTED' : 'DRY RUN'));
            $this->line('specialty_id='.($outcome['specialty_id'] ?? 'n/a').' department_id='.($outcome['department_id'] ?? 'n/a').' doctor_updated='.($outcome['doctor_updated'] ? 'yes' : 'no'));
            if ($outcome['snapshot']) {
                $this->line('Rollback snapshot: '.$outcome['snapshot']);
            }
        }
    }

    /**
     * Translate the curated, canonical-name-keyed manual schedule
     * corrections in config into the (doctor_id:branch_id) keys
     * DoctorSyncService::syncSchedules() expects, using this run's audit
     * result so ids are always resolved fresh rather than hard-coded.
     *
     * @return array<string, array{days: ?string, time: string}>
     */
    protected function resolveManualScheduleCorrections(array $result): array
    {
        $curated = (array) config('doctor_sync.manual_schedule_corrections', []);
        $resolved = [];

        foreach ($result['schedules'] as $row) {
            if (! isset($row['doctor_id'])) {
                continue;
            }

            $canonical = collect($result['doctors'])->firstWhere('doctor_id', $row['doctor_id'])['canonical'] ?? null;

            if ($canonical === null) {
                continue;
            }

            $key = $canonical.':'.$row['branch_token'];

            if (isset($curated[$key])) {
                // Only forward the curated override as-is; DoctorSyncService
                // owns falling back to the normalizer's value for whichever
                // of days/time this correction doesn't specify.
                $resolved[$row['doctor_id'].':'.$row['branch_id']] = [
                    'days' => $curated[$key]['days'] ?? null,
                    'time' => $curated[$key]['time'] ?? null,
                ];
            }
        }

        return $resolved;
    }

    /**
     * Print original-vs-corrected values for every manually corrected row,
     * one line per row, before the aggregate sync outcome. A count alone
     * ("2 manually corrected") isn't enough of an audit trail for a change to
     * a patient-facing clinic hour - the operator should see exactly which
     * doctor, which branch, and what the text changed from and to.
     */
    protected function printManualScheduleCorrections(array $result, array $manual): void
    {
        if ($manual === []) {
            return;
        }

        $this->newLine();
        $this->comment('Manual schedule corrections to be applied:');

        foreach ($result['schedules'] as $row) {
            if (! isset($row['doctor_id'])) {
                continue;
            }

            $key = $row['doctor_id'].':'.$row['branch_id'];

            if (! isset($manual[$key])) {
                continue;
            }

            $newTime = $manual[$key]['time'] ?? $row['time_proposed'];
            $newDays = $manual[$key]['days'] ?? $row['days_proposed'];

            $this->line(sprintf(
                '  %s (branch %s): time "%s" -> "%s"%s',
                $row['doctor_name'],
                $row['branch_id'],
                $row['time_workbook'],
                $newTime,
                $manual[$key]['days'] !== null ? sprintf(' | days "%s" -> "%s"', $row['days_workbook'], $newDays) : ''
            ));
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function readCsv(string $path): array
    {
        if (! is_file($path)) {
            $this->error("CSV not found: {$path}");

            return [];
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $rows = [];

        while (($line = fgetcsv($handle)) !== false) {
            $row = array_combine($header, $line);
            $row['doctor_id'] = $row['doctor_id'] !== '' ? (int) $row['doctor_id'] : null;
            $rows[] = $row;
        }

        fclose($handle);

        return $rows;
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
