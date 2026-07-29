<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorBranchSchedule;
use App\Models\DoctorConsultationBooking;
use App\Support\DoctorBookingGuard;
use App\Support\DoctorImagePresenter;
use App\Support\ScheduleNormalizer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use RuntimeException;

/**
 * Compares the source workbooks, the photo folder, and the database, and
 * reports every difference.
 *
 * This class is READ-ONLY by construction. It issues no INSERT, UPDATE or
 * DELETE, touches no file, and has no --execute path. Its entire output is a
 * data structure describing what a later, separately approved correction step
 * would change.
 *
 * Matching never falls back to fuzzy similarity. A workbook row either matches
 * exactly after normalisation, matches through a curated alias, or is reported
 * for a human to resolve.
 */
class DoctorAuditService
{
    /**
     * Run the full audit.
     *
     * @return array<string, mixed>
     */
    public function audit(string $sourceDir): array
    {
        $sourceDir = rtrim($sourceDir, '\\/');

        if (! is_dir($sourceDir)) {
            throw new RuntimeException("Source directory not found: {$sourceDir}");
        }

        $profiles = $this->loadProfiles($sourceDir);
        $scheduleRows = $this->loadScheduleRows($sourceDir);
        $sourceImages = $this->loadSourceImages($sourceDir);

        $doctors = Doctor::withTrashed()->with(['specialty', 'department'])->orderBy('id')->get();
        $branchResolution = $this->resolveBranches($scheduleRows);

        $doctorAudit = $this->auditDoctors($doctors, $profiles, $sourceImages);
        $scheduleAudit = $this->auditSchedules($scheduleRows, $doctors, $branchResolution['map']);
        $imageAudit = $this->auditImages($doctors, $sourceImages);

        return [
            'environment' => $this->environmentContext($sourceDir),
            'counts' => [
                'profile_rows' => count($profiles),
                'schedule_rows' => count($scheduleRows),
                'source_images' => count($sourceImages),
                'db_doctors' => $doctors->count(),
                'db_doctors_trashed' => $doctors->filter->trashed()->count(),
                'db_schedules' => DoctorBranchSchedule::count(),
                'db_bookings' => DoctorConsultationBooking::count(),
                'db_branches' => Branch::count(),
            ],
            'branches' => $branchResolution,
            'doctors' => $doctorAudit['rows'],
            'conflicts' => $doctorAudit['conflicts'],
            'fillable_blanks' => $doctorAudit['fillable_blanks'],
            'unmatched_profiles' => $doctorAudit['unmatched_profiles'],
            'ambiguous' => array_merge($doctorAudit['ambiguous'], $scheduleAudit['ambiguous']),
            'gender_needed' => $doctorAudit['gender_needed'],
            'fees_needed' => $doctorAudit['fees_needed'],
            'schedules' => $scheduleAudit['rows'],
            'schedule_conflicts' => $scheduleAudit['conflicts'],
            'cross_branch_overlaps' => $scheduleAudit['overlaps'],
            'images' => $imageAudit,
            'skipped' => array_merge($doctorAudit['skipped'], $scheduleAudit['skipped']),
        ];
    }

    /* -----------------------------------------------------------------
     | Normalisation
     | -----------------------------------------------------------------
     */

    /**
     * Reduce a doctor name to a comparable key.
     *
     * Strips honorifics, punctuation and invisible characters. Two names that
     * normalise to the same string are treated as the same person; two that do
     * not are only ever linked through the curated alias table.
     */
    public static function normalizeName(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $value = str_replace(["\u{200B}", "\u{200C}", "\u{200D}", "\u{FEFF}", "\u{00A0}"], ' ', $value);
        $value = Str::lower(trim($value));

        // Punctuation is flattened BEFORE honorifics are stripped. The
        // workbooks contain names written "Dr.Pavel Chowdhuray" with no space
        // after the title; stripping first would leave "dr pavel chowdhuray"
        // and the row would never match its database record.
        $value = str_replace(['.', ',', '-', '&', '_', '/', "'", '"'], ' ', $value);
        $value = preg_replace('/\s+/u', ' ', $value) ?? '';
        $value = trim($value);

        // Repeatedly strip leading honorifics: "Prof Dr Md X" -> "x".
        do {
            $before = $value;
            $value = preg_replace('/^(prof(essor)?|dr|doctor|md|mr|mrs|ms)\s+/u', '', $value) ?? $value;
        } while ($value !== $before);

        return trim($value);
    }

    /**
     * Apply the curated alias table to a normalised name.
     *
     * An alias asserts that two spellings are the same human. It is a reviewed
     * mapping in config/doctor_sync.php, never a similarity score.
     */
    public static function canonicalName(?string $value): string
    {
        $normalized = self::normalizeName($value);
        $aliases = (array) config('doctor_sync.doctor_aliases', []);

        return $aliases[$normalized] ?? $normalized;
    }

    /**
     * Reduce a branch label to a comparable token such as "hatirpool".
     */
    public static function normalizeBranch(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $value = Str::lower(trim($value));

        // "Branch : Hatirpool Branch" -> "hatirpool branch"
        if (str_contains($value, ':')) {
            $value = trim(Str::after($value, ':'));
        }

        foreach ((array) config('doctor_sync.branch_noise', []) as $noise) {
            $value = str_replace(Str::lower($noise), ' ', $value);
        }

        $value = str_replace(['(', ')', '.', '-', '_', ','], ' ', $value);
        $value = preg_replace('/\s+/u', ' ', $value) ?? '';

        return trim($value);
    }

    /**
     * Lower-case an email, returning null when blank or fabricated.
     */
    public static function normalizeEmail(?string $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = strtolower(trim($value));

        if ($value === '') {
            return null;
        }

        $fabricated = array_map('strtolower', (array) config('doctor_sync.fabricated.emails', []));

        return in_array($value, $fabricated, true) ? null : $value;
    }

    /**
     * Reduce a phone to digits, returning null when blank or fabricated.
     */
    public static function normalizePhone(?string $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value) ?? '';

        if (strlen($digits) > 11 && str_starts_with($digits, '88')) {
            $digits = substr($digits, 2);
        }

        if ($digits === '') {
            return null;
        }

        return in_array($digits, (array) config('doctor_sync.fabricated.phones', []), true) ? null : $digits;
    }

    /**
     * Classify a stored value so the correction step knows whether it may be
     * written over. See the plan's field write policy.
     */
    public static function classifyValue(?string $dbValue, ?string $sourceValue): string
    {
        if ($dbValue === null) {
            return 'NULL';
        }

        if ($dbValue === '') {
            return 'BLANK';
        }

        if (trim($dbValue) === '') {
            return 'WHITESPACE_ONLY';
        }

        $pattern = (string) config('doctor_sync.placeholder_pattern', '/^$/');

        if ($pattern !== '' && preg_match($pattern, trim($dbValue)) === 1) {
            return 'SUSPECTED_PLACEHOLDER';
        }

        if ($sourceValue === null || trim($sourceValue) === '') {
            return 'NO_SOURCE_VALUE';
        }

        return self::looselyEqual($dbValue, $sourceValue) ? 'MEANINGFUL_MATCH' : 'MEANINGFUL_CONFLICT';
    }

    /**
     * Whitespace- and case-insensitive comparison for free-text fields.
     */
    public static function looselyEqual(?string $a, ?string $b): bool
    {
        $clean = static fn (?string $v) => Str::lower(preg_replace('/\s+/u', ' ', trim((string) $v)) ?? '');

        return $clean($a) === $clean($b);
    }

    /* -----------------------------------------------------------------
     | Source loading
     | -----------------------------------------------------------------
     */

    /**
     * Read doctors.xlsx.
     *
     * Only columns C..G carry structured data; columns A and B hold leftover
     * scratch text and rows past the profile block hold the original
     * unstructured notes. Both are ignored.
     *
     * @return array<int, array<string, mixed>>
     */
    public function loadProfiles(string $sourceDir): array
    {
        $config = (array) config('doctor_sync.sources.profile', []);
        $columns = (array) ($config['columns'] ?? []);
        $firstRow = (int) ($config['first_data_row'] ?? 2);

        $file = $sourceDir.DIRECTORY_SEPARATOR.config('doctor_sync.sources.profile_workbook', 'doctors.xlsx');

        if (! is_file($file)) {
            throw new RuntimeException("Profile workbook not found: {$file}");
        }

        $rows = IOFactory::load($file)->getActiveSheet()->toArray(null, true, true, true);
        $profiles = [];

        foreach ($rows as $index => $row) {
            if ($index < $firstRow) {
                continue;
            }

            $name = trim((string) ($row[$columns['name'] ?? 'C'] ?? ''));

            if ($name === '') {
                continue;
            }

            $profiles[] = [
                'row' => $index,
                'source' => basename($file),
                'name' => $name,
                'canonical' => self::canonicalName($name),
                'qualification' => trim((string) ($row[$columns['qualification'] ?? 'D'] ?? '')) ?: null,
                'designation' => trim((string) ($row[$columns['designation'] ?? 'E'] ?? '')) ?: null,
                'address' => trim((string) ($row[$columns['address'] ?? 'F'] ?? '')) ?: null,
                'bio' => trim((string) ($row[$columns['bio'] ?? 'G'] ?? '')) ?: null,
            ];
        }

        return $profiles;
    }

    /**
     * Read every "Doctors Schedule*.xlsx" in the source directory.
     *
     * @return array<int, array<string, mixed>>
     */
    public function loadScheduleRows(string $sourceDir): array
    {
        $config = (array) config('doctor_sync.sources.schedule', []);
        $columns = (array) ($config['columns'] ?? []);
        $firstRow = (int) ($config['first_data_row'] ?? 5);
        $branchCell = (string) ($config['branch_cell'] ?? 'A3');

        $pattern = $sourceDir.DIRECTORY_SEPARATOR.config('doctor_sync.sources.schedule_workbook_glob', 'Doctors Schedule*.xlsx');
        $files = glob($pattern) ?: [];
        sort($files);

        if ($files === []) {
            throw new RuntimeException("No schedule workbooks matched: {$pattern}");
        }

        $out = [];

        foreach ($files as $file) {
            $sheet = IOFactory::load($file)->getActiveSheet();
            $rawBranch = trim((string) $sheet->getCell($branchCell)->getValue());
            $rows = $sheet->toArray(null, true, true, true);

            foreach ($rows as $index => $row) {
                if ($index < $firstRow) {
                    continue;
                }

                $name = trim((string) ($row[$columns['name'] ?? 'B'] ?? ''));

                if ($name === '') {
                    continue; // Trailing rows carrying only a serial number.
                }

                $out[] = [
                    'row' => $index,
                    'source' => basename($file),
                    'raw_branch' => $rawBranch,
                    'branch_token' => self::normalizeBranch($rawBranch) ?: self::normalizeBranch(pathinfo($file, PATHINFO_FILENAME)),
                    'name' => $name,
                    'canonical' => self::canonicalName($name),
                    'consultant' => trim((string) ($row[$columns['consultant'] ?? 'C'] ?? '')) ?: null,
                    'days_raw' => trim((string) ($row[$columns['days'] ?? 'D'] ?? '')) ?: null,
                    'time_raw' => trim((string) ($row[$columns['time'] ?? 'E'] ?? '')) ?: null,
                ];
            }
        }

        return $out;
    }

    /**
     * Index the provided photo folder by canonical doctor name.
     *
     * Files whose name contains "avatar" are shared assets, not doctor photos,
     * and are excluded so they can never be matched to a person.
     *
     * @return array<string, array<string, mixed>>
     */
    public function loadSourceImages(string $sourceDir): array
    {
        $directory = $sourceDir.DIRECTORY_SEPARATOR.config('doctor_sync.sources.image_directory', 'images');

        if (! is_dir($directory)) {
            return [];
        }

        $images = [];

        foreach (glob($directory.DIRECTORY_SEPARATOR.'*') ?: [] as $file) {
            if (! is_file($file)) {
                continue;
            }

            $basename = basename($file);

            if (Str::contains(Str::lower($basename), 'avatar')) {
                continue;
            }

            $stem = pathinfo($basename, PATHINFO_FILENAME);

            $images[self::canonicalName($stem)] = [
                'filename' => $basename,
                'path' => $file,
                'sha256' => hash_file('sha256', $file),
                'bytes' => filesize($file),
                'slug' => Str::slug($stem),
            ];
        }

        return $images;
    }

    /* -----------------------------------------------------------------
     | Audits
     | -----------------------------------------------------------------
     */

    /**
     * Resolve every workbook branch token to a branch row, by name.
     *
     * Ids are never hard-coded: they differ between environments. An
     * unresolvable branch is a hard error rather than a guess.
     *
     * @param  array<int, array<string, mixed>>  $scheduleRows
     * @return array{map: array<string, int>, resolved: array<int, array<string, mixed>>, unresolved: array<int, string>}
     */
    public function resolveBranches(array $scheduleRows): array
    {
        $aliases = (array) config('doctor_sync.branch_aliases', []);

        $branchesByToken = [];
        foreach (Branch::query()->get(['id', 'name', 'title']) as $branch) {
            foreach (array_filter([$branch->title, $branch->name]) as $label) {
                $token = self::normalizeBranch($label);

                if ($token !== '') {
                    $branchesByToken[$aliases[$token] ?? $token] = $branch->id;
                }
            }
        }

        $map = [];
        $resolved = [];
        $unresolved = [];

        foreach (array_unique(array_column($scheduleRows, 'branch_token')) as $token) {
            $canonical = $aliases[$token] ?? $token;
            $branchId = $branchesByToken[$canonical] ?? null;

            if ($branchId === null) {
                $unresolved[] = $token;

                continue;
            }

            $map[$token] = $branchId;
            $branch = Branch::find($branchId);

            $resolved[] = [
                'workbook_token' => $token,
                'canonical_token' => $canonical,
                'branch_id' => $branchId,
                'branch_name' => $branch ? ($branch->title ?: $branch->name) : null,
            ];
        }

        return ['map' => $map, 'resolved' => $resolved, 'unresolved' => $unresolved];
    }

    /**
     * Compare each database doctor against the workbook profile, if any.
     *
     * @return array<string, mixed>
     */
    protected function auditDoctors($doctors, array $profiles, array $sourceImages): array
    {
        $profilesByCanonical = [];
        foreach ($profiles as $profile) {
            $profilesByCanonical[$profile['canonical']][] = $profile;
        }

        // Doctors sharing a canonical name must be considered together: a
        // profile matching one of them is not evidence for which one it
        // belongs to. Grouping this direction is what test coverage caught
        // missing - previously two DB doctors with the same name would both
        // silently receive the SAME profile, because each was checked against
        // the profile list in isolation.
        $doctorsByCanonical = [];
        foreach ($doctors as $doctor) {
            $doctorsByCanonical[self::canonicalName($doctor->name)][] = $doctor->id;
        }

        $rows = [];
        $conflicts = [];
        $fillableBlanks = [];
        $ambiguous = [];
        $genderNeeded = [];
        $feesNeeded = [];
        $skipped = [];
        $matchedProfileKeys = [];
        $reportedAmbiguousCanonicals = [];

        foreach ($doctors as $doctor) {
            $canonical = self::canonicalName($doctor->name);
            $candidates = $profilesByCanonical[$canonical] ?? [];
            $doctorsSharingName = $doctorsByCanonical[$canonical] ?? [];

            $profile = null;
            $matchMethod = 'NONE';

            if (count($candidates) === 1 && count($doctorsSharingName) === 1) {
                // Exactly one doctor and exactly one profile share this name:
                // the only case safe to auto-match.
                $profile = $candidates[0];
                $matchMethod = self::normalizeName($doctor->name) === self::normalizeName($profile['name'])
                    ? 'EXACT_NAME'
                    : 'CURATED_ALIAS';
                $matchedProfileKeys[$canonical] = true;
            } elseif ($candidates !== [] && count($doctorsSharingName) > 1) {
                // Multiple doctors share this name: a profile cannot be
                // attributed to any one of them without a guess. Reported once
                // per canonical name, not once per doctor.
                if (! isset($reportedAmbiguousCanonicals[$canonical])) {
                    $reportedAmbiguousCanonicals[$canonical] = true;
                    $ambiguous[] = [
                        'type' => 'DOCTOR_PROFILE',
                        'doctor_id' => implode(',', $doctorsSharingName),
                        'doctor_name' => $doctor->name,
                        'reason' => 'Multiple database doctors share this normalised name; a workbook profile cannot be attributed to one of them',
                        'candidates' => implode(' | ', array_map(fn ($id) => "#{$id}", $doctorsSharingName)),
                    ];
                }

                $skipped[] = [
                    'area' => 'doctor',
                    'reference' => $doctor->id,
                    'reason' => 'AMBIGUOUS_MATCH',
                ];
            } elseif (count($candidates) > 1) {
                // Never guess between two profile candidates.
                $ambiguous[] = [
                    'type' => 'DOCTOR_PROFILE',
                    'doctor_id' => $doctor->id,
                    'doctor_name' => $doctor->name,
                    'reason' => 'Multiple workbook profiles normalise to the same name',
                    'candidates' => implode(' | ', array_column($candidates, 'name')),
                ];
                $skipped[] = [
                    'area' => 'doctor',
                    'reference' => $doctor->id,
                    'reason' => 'AMBIGUOUS_MATCH',
                ];
            }

            $fields = [];
            foreach (['qualification', 'designation', 'address', 'bio'] as $field) {
                $dbValue = $doctor->{$field};
                $sourceValue = $profile[$field] ?? null;
                $class = self::classifyValue($dbValue, $sourceValue);

                $fields[$field] = [
                    'db' => $dbValue,
                    'source' => $sourceValue,
                    'classification' => $class,
                ];

                if ($class === 'MEANINGFUL_CONFLICT') {
                    $conflicts[] = [
                        'doctor_id' => $doctor->id,
                        'doctor_name' => $doctor->name,
                        'field' => $field,
                        'db_value' => $dbValue,
                        'workbook_value' => $sourceValue,
                        'classification' => $class,
                    ];
                }

                if (in_array($class, ['NULL', 'BLANK', 'WHITESPACE_ONLY'], true) && $sourceValue !== null) {
                    $fillableBlanks[] = [
                        'doctor_id' => $doctor->id,
                        'doctor_name' => $doctor->name,
                        'field' => $field,
                        'proposed_value' => $sourceValue,
                        'classification' => $class,
                    ];
                }

                if ($class === 'SUSPECTED_PLACEHOLDER') {
                    $skipped[] = [
                        'area' => 'doctor',
                        'reference' => $doctor->id.'.'.$field,
                        'reason' => 'SUSPECTED_PLACEHOLDER',
                    ];
                }
            }

            // Gender does not exist as a column yet, so this is always "needed"
            // until Gate B adds it and someone fills it in. It is never guessed.
            $gender = $doctor->getAttribute('gender');
            if (! in_array($gender, ['male', 'female', 'other'], true)) {
                $genderNeeded[] = [
                    'doctor_id' => $doctor->id,
                    'doctor_name' => $doctor->name,
                    'specialty' => optional($doctor->specialty)->name,
                    'has_personal_photo' => DoctorImagePresenter::hasPersonalImage($doctor) ? 'yes' : 'no',
                    'current_gender' => $gender ?? '(column not present)',
                ];
            }

            if ((float) $doctor->consultation_fee <= 0) {
                $feesNeeded[] = [
                    'doctor_id' => $doctor->id,
                    'doctor_name' => $doctor->name,
                    'consultation_fee' => $doctor->consultation_fee,
                    'video_consultation_fee' => $doctor->video_consultation_fee,
                ];
            }

            $rows[] = [
                'doctor_id' => $doctor->id,
                'name' => $doctor->name,
                'canonical' => $canonical,
                'code' => $doctor->code,
                'slug' => $doctor->slug,
                'status' => (int) $doctor->status,
                'trashed' => $doctor->trashed(),
                'specialty' => optional($doctor->specialty)->name,
                'department' => optional($doctor->department)->name,
                'email' => $doctor->email,
                'email_is_fabricated' => $doctor->email !== null && self::normalizeEmail($doctor->email) === null,
                'phone' => $doctor->phone,
                'phone_is_fabricated' => $doctor->phone !== null && self::normalizePhone($doctor->phone) === null,
                'consultation_fee' => $doctor->consultation_fee,
                'image' => $doctor->image,
                'image_status' => $this->imageStatus($doctor),
                'profile_match' => $matchMethod,
                'profile_name' => $profile['name'] ?? null,
                'has_source_photo' => isset($sourceImages[$canonical]) ? 'yes' : 'no',
                'fields' => $fields,
            ];
        }

        // Workbook profiles with no database counterpart.
        $unmatchedProfiles = [];
        foreach ($profiles as $profile) {
            if (! isset($matchedProfileKeys[$profile['canonical']])) {
                $unmatchedProfiles[] = [
                    'workbook_row' => $profile['row'],
                    'name' => $profile['name'],
                    'canonical' => $profile['canonical'],
                    'designation' => $profile['designation'],
                    'qualification' => $profile['qualification'],
                    'has_source_photo' => isset($sourceImages[$profile['canonical']]) ? 'yes' : 'no',
                    'source_photo' => $sourceImages[$profile['canonical']]['filename'] ?? null,
                ];
            }
        }

        return [
            'rows' => $rows,
            'conflicts' => $conflicts,
            'fillable_blanks' => $fillableBlanks,
            'unmatched_profiles' => $unmatchedProfiles,
            'ambiguous' => $ambiguous,
            'gender_needed' => $genderNeeded,
            'fees_needed' => $feesNeeded,
            'skipped' => $skipped,
        ];
    }

    /**
     * Produce the field-level schedule diff.
     *
     * Nothing here is applied. Each row records what the workbook says, what
     * the database holds, what a normalised value would be, and whether that
     * normalisation needed a judgement call.
     *
     * @return array<string, mixed>
     */
    protected function auditSchedules(array $scheduleRows, $doctors, array $branchMap): array
    {
        $doctorsByCanonical = [];
        foreach ($doctors as $doctor) {
            $doctorsByCanonical[self::canonicalName($doctor->name)][] = $doctor;
        }

        $existing = DoctorBranchSchedule::query()->get()->keyBy(fn ($s) => $s->doctor_id.':'.$s->branch_id);

        $rows = [];
        $conflicts = [];
        $ambiguous = [];
        $skipped = [];
        $seen = [];

        foreach ($scheduleRows as $row) {
            $candidates = $doctorsByCanonical[$row['canonical']] ?? [];
            $branchId = $branchMap[$row['branch_token']] ?? null;

            $days = ScheduleNormalizer::days($row['days_raw']);
            $time = ScheduleNormalizer::time($row['time_raw']);

            $entry = [
                'source' => $row['source'],
                'workbook_row' => $row['row'],
                'workbook_name' => $row['name'],
                'branch_token' => $row['branch_token'],
                'branch_id' => $branchId,
                'consultant' => $row['consultant'],
                'days_workbook' => $row['days_raw'],
                'days_proposed' => $days['value'],
                'days_flags' => $days['flags'],
                'time_workbook' => $row['time_raw'],
                'time_proposed' => $time['value'],
                'time_flags' => $time['flags'],
                'requires_approval' => $days['requires_approval'] || $time['requires_approval'],
            ];

            if ($branchId === null) {
                $entry['status'] = 'UNRESOLVED_BRANCH';
                $skipped[] = ['area' => 'schedule', 'reference' => $row['source'].':'.$row['row'], 'reason' => 'UNRESOLVED_BRANCH'];
                $rows[] = $entry;

                continue;
            }

            if (count($candidates) !== 1) {
                $entry['status'] = $candidates === [] ? 'UNMATCHED_DOCTOR' : 'AMBIGUOUS_DOCTOR';

                if ($candidates !== []) {
                    $ambiguous[] = [
                        'type' => 'SCHEDULE_DOCTOR',
                        'source' => $row['source'],
                        'workbook_row' => $row['row'],
                        'workbook_name' => $row['name'],
                        'reason' => 'Name matches more than one doctor',
                        'candidates' => implode(' | ', array_map(fn ($d) => "#{$d->id} {$d->name}", $candidates)),
                    ];
                }

                $skipped[] = ['area' => 'schedule', 'reference' => $row['source'].':'.$row['row'], 'reason' => $entry['status']];
                $rows[] = $entry;

                continue;
            }

            $doctor = $candidates[0];
            $key = $doctor->id.':'.$branchId;

            // Two workbook rows for the same doctor at the same branch cannot
            // both be stored: the table has a unique constraint on the pair.
            if (isset($seen[$key])) {
                $entry['status'] = 'DUPLICATE_WORKBOOK_ROW';
                $conflicts[] = [
                    'doctor_id' => $doctor->id,
                    'doctor_name' => $doctor->name,
                    'branch_id' => $branchId,
                    'reason' => 'Two workbook rows target the same doctor and branch',
                    'first_row' => $seen[$key],
                    'second_row' => $row['source'].':'.$row['row'],
                ];
                $skipped[] = ['area' => 'schedule', 'reference' => $row['source'].':'.$row['row'], 'reason' => 'DUPLICATE_WORKBOOK_ROW'];
                $rows[] = $entry;

                continue;
            }

            $seen[$key] = $row['source'].':'.$row['row'];

            $current = $existing->get($key);
            $entry['doctor_id'] = $doctor->id;
            $entry['doctor_name'] = $doctor->name;
            $entry['days_db'] = $current->schedule_days ?? null;
            $entry['time_db'] = $current->schedule_time ?? null;
            $entry['consultant_db'] = $current->consultant ?? null;
            $entry['blocking_bookings'] = $this->blockingBookingCount($doctor->id, $branchId);

            if ($entry['blocking_bookings'] > 0) {
                $entry['status'] = 'PROTECTED_BY_BOOKINGS';
                $skipped[] = [
                    'area' => 'schedule',
                    'reference' => $row['source'].':'.$row['row'],
                    'reason' => 'PROTECTED_BY_BOOKINGS('.$entry['blocking_bookings'].')',
                ];
            } elseif ($current === null) {
                $entry['status'] = 'MISSING_IN_DB';
            } elseif ($entry['requires_approval']) {
                $entry['status'] = 'NEEDS_APPROVAL';
                $skipped[] = [
                    'area' => 'schedule',
                    'reference' => $row['source'].':'.$row['row'],
                    'reason' => implode(',', array_merge($days['flags'], $time['flags'])),
                ];
            } elseif ($entry['days_db'] === $entry['days_proposed'] && $entry['time_db'] === $entry['time_proposed']) {
                $entry['status'] = 'UP_TO_DATE';
            } else {
                $entry['status'] = 'WOULD_NORMALISE';
            }

            $rows[] = $entry;
        }

        return [
            'rows' => $rows,
            'conflicts' => $conflicts,
            'overlaps' => $this->findCrossBranchOverlaps($rows),
            'ambiguous' => $ambiguous,
            'skipped' => $skipped,
        ];
    }

    /**
     * Report doctors whose two branch schedules collide on the same weekday.
     *
     * Reported only. The schedule text is display-only and booking is slot
     * based, so an overlap is a data-quality signal rather than a blocker.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function findCrossBranchOverlaps(array $rows): array
    {
        $byDoctor = [];

        foreach ($rows as $row) {
            if (! isset($row['doctor_id'])) {
                continue;
            }

            $byDoctor[$row['doctor_id']][] = $row;
        }

        $overlaps = [];

        foreach ($byDoctor as $doctorId => $entries) {
            if (count($entries) < 2) {
                continue;
            }

            for ($i = 0; $i < count($entries); $i++) {
                for ($j = $i + 1; $j < count($entries); $j++) {
                    $a = $entries[$i];
                    $b = $entries[$j];

                    if ($a['branch_id'] === $b['branch_id']) {
                        continue;
                    }

                    $aDays = ScheduleNormalizer::days($a['days_workbook']);
                    $bDays = ScheduleNormalizer::days($b['days_workbook']);
                    $shared = array_intersect($aDays['days'], $bDays['days']);

                    if ($shared === []) {
                        continue;
                    }

                    $aTime = ScheduleNormalizer::time($a['time_workbook']);
                    $bTime = ScheduleNormalizer::time($b['time_workbook']);

                    if (ScheduleNormalizer::overlaps($aTime, $bTime)) {
                        $overlaps[] = [
                            'doctor_id' => $doctorId,
                            'doctor_name' => $a['doctor_name'] ?? null,
                            'days' => implode(', ', $shared),
                            'branch_a' => $a['branch_id'],
                            'time_a' => $aTime['value'],
                            'branch_b' => $b['branch_id'],
                            'time_b' => $bTime['value'],
                        ];
                    }
                }
            }
        }

        return $overlaps;
    }

    /**
     * Audit stored image paths against what is actually on disk.
     *
     * @return array<string, mixed>
     */
    protected function auditImages($doctors, array $sourceImages): array
    {
        $broken = [];
        $valid = [];
        $missing = [];
        $referenced = [];
        $unsafe = [];

        foreach ($doctors as $doctor) {
            $status = $this->imageStatus($doctor);

            $record = [
                'doctor_id' => $doctor->id,
                'doctor_name' => $doctor->name,
                'image' => $doctor->image,
                'status' => $status,
                'effective_url' => DoctorImagePresenter::url($doctor),
            ];

            if ($status === 'OK') {
                $path = public_path($doctor->image);
                $record['sha256'] = hash_file('sha256', $path);
                $record['bytes'] = filesize($path);
                $referenced[$doctor->image] = true;
                $valid[] = $record;
            } elseif ($status === 'BROKEN') {
                $broken[] = $record;
            } elseif ($status === 'UNSAFE_PATH') {
                $unsafe[] = $record;
            } else {
                $missing[] = $record;
            }
        }

        // Files present on disk that no doctor row points at.
        $orphans = [];
        $base = public_path((string) config('doctor_sync.uploads.base_directory', 'uploads/doctors'));

        foreach ($this->listFilesRecursively($base) as $file) {
            $relative = str_replace('\\', '/', Str::after($file, public_path().DIRECTORY_SEPARATOR));
            $relative = str_replace('\\', '/', $relative);

            if (isset($referenced[$relative])) {
                continue;
            }

            $sha = hash_file('sha256', $file);
            $matchedSource = null;

            foreach ($sourceImages as $canonical => $image) {
                if ($image['sha256'] === $sha) {
                    $matchedSource = ['canonical' => $canonical, 'filename' => $image['filename']];

                    break;
                }
            }

            $orphans[] = [
                'path' => $relative,
                'sha256' => $sha,
                'bytes' => filesize($file),
                'matches_source_photo' => $matchedSource['filename'] ?? null,
                'matches_canonical_name' => $matchedSource['canonical'] ?? null,
            ];
        }

        // Provided photos that correspond to no doctor in the database.
        $doctorCanonicals = [];
        foreach ($doctors as $doctor) {
            $doctorCanonicals[self::canonicalName($doctor->name)] = true;
        }

        $unmatchedSourceImages = [];
        foreach ($sourceImages as $canonical => $image) {
            if (! isset($doctorCanonicals[$canonical])) {
                $unmatchedSourceImages[] = [
                    'filename' => $image['filename'],
                    'canonical' => $canonical,
                    'sha256' => $image['sha256'],
                ];
            }
        }

        return [
            'valid' => $valid,
            'broken' => $broken,
            'unsafe' => $unsafe,
            'no_image' => $missing,
            'orphan_files' => $orphans,
            'unmatched_source_photos' => $unmatchedSourceImages,
            'source_photo_checksums' => array_map(
                fn ($image) => ['filename' => $image['filename'], 'sha256' => $image['sha256'], 'bytes' => $image['bytes']],
                array_values($sourceImages)
            ),
        ];
    }

    /**
     * Classify a doctor's stored image path.
     */
    protected function imageStatus(Doctor $doctor): string
    {
        if ($doctor->image === null || trim((string) $doctor->image) === '') {
            return 'NO_IMAGE';
        }

        $safe = DoctorImagePresenter::safeRelativePath($doctor->image);

        if ($safe === null) {
            return 'UNSAFE_PATH';
        }

        return is_file(public_path($safe)) ? 'OK' : 'BROKEN';
    }

    /**
     * Count bookings that would make a schedule row unsafe to change.
     *
     * Delegates to DoctorBookingGuard, which is also used by the admin
     * controller, so a report of "protected" always matches what the write
     * path would actually protect.
     */
    protected function blockingBookingCount(int $doctorId, int $branchId): int
    {
        return DoctorBookingGuard::blockingBookingCount($doctorId, $branchId);
    }

    /**
     * @return array<int, string>
     */
    protected function listFilesRecursively(string $directory): array
    {
        if (! is_dir($directory)) {
            return [];
        }

        $files = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }

        sort($files);

        return $files;
    }

    /**
     * Context recorded in every report so a run can be traced to where it ran.
     *
     * @return array<string, mixed>
     */
    protected function environmentContext(string $sourceDir): array
    {
        return [
            'app_env' => config('app.env'),
            'app_timezone' => config('app.timezone'),
            'database' => config('database.connections.'.config('database.default').'.database'),
            'connection' => config('database.default'),
            'source_directory' => $sourceDir,
            'php_version' => PHP_VERSION,
            'generated_at' => Carbon::now(config('app.timezone'))->toIso8601String(),
        ];
    }
}
