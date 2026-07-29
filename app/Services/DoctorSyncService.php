<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\DoctorBranchSchedule;
use App\Models\DoctorDepartment;
use App\Models\DoctorSpecialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * The write side of the doctor-data correction tooling. DoctorAuditService is
 * strictly read-only; every method here takes ITS output as input and decides
 * what, if anything, to persist.
 *
 * Every public method:
 *   - defaults to a dry run (returns what it WOULD do) unless $execute is true
 *   - wraps its writes in one DB transaction
 *   - records a before-image via DoctorSyncSnapshot before mutating anything,
 *     so `doctor:audit:rollback` can undo it precisely
 *   - never writes a field the audit did not already classify as safe (a
 *     NULL/blank/fabricated value, or an explicitly approved correction) -
 *     see DoctorAuditService::classifyValue() and the plan's field policy
 */
class DoctorSyncService
{
    /**
     * Build the gender proposal rows from a curated map, for review before
     * anything is written. Never guesses: a name absent from
     * config('doctor_sync.gender_map') is reported, not inferred live.
     *
     * @return array<int, array<string, mixed>>
     */
    public function proposeGender(array $auditResult): array
    {
        $map = (array) config('doctor_sync.gender_map', []);
        $rows = [];

        foreach ($auditResult['doctors'] as $doctor) {
            $proposed = $map[$doctor['canonical']] ?? null;

            $rows[] = [
                'doctor_id' => $doctor['doctor_id'],
                'name' => $doctor['name'],
                'canonical' => $doctor['canonical'],
                'current_gender' => null, // doctors.gender did not exist before Gate B
                'proposed_gender' => $proposed,
                'in_curated_map' => $proposed !== null ? 'yes' : 'no',
            ];
        }

        foreach ($auditResult['unmatched_profiles'] as $profile) {
            $proposed = $map[$profile['canonical']] ?? null;

            $rows[] = [
                'doctor_id' => null,
                'name' => $profile['name'],
                'canonical' => $profile['canonical'],
                'current_gender' => null,
                'proposed_gender' => $proposed,
                'in_curated_map' => $proposed !== null ? 'yes' : 'no',
            ];
        }

        return $rows;
    }

    /**
     * Apply gender from a (possibly operator-edited) CSV of proposeGender()
     * rows. Only rows with a non-null `doctor_id` and a valid `proposed_gender`
     * are applied. A doctor whose gender is already set is skipped, never
     * overwritten - this is what makes re-running idempotent and safe even if
     * an operator applies an old CSV twice.
     *
     * @param  array<int, array<string, mixed>>  $rows
     * @return array{updated: int, skipped_already_set: int, skipped_no_value: int, snapshot: ?string}
     */
    public function applyGender(array $rows, bool $execute): array
    {
        $snapshot = new DoctorSyncSnapshot('apply-gender');
        $updated = 0;
        $skippedAlreadySet = 0;
        $skippedNoValue = 0;

        $valid = ['male', 'female', 'other'];

        DB::transaction(function () use ($rows, $execute, $snapshot, $valid, &$updated, &$skippedAlreadySet, &$skippedNoValue) {
            foreach ($rows as $row) {
                $doctorId = $row['doctor_id'] ?? null;
                $gender = $row['proposed_gender'] ?? null;

                if (blank($doctorId) || ! in_array($gender, $valid, true)) {
                    $skippedNoValue++;

                    continue;
                }

                $doctor = Doctor::find($doctorId);

                if (! $doctor) {
                    $skippedNoValue++;

                    continue;
                }

                if ($doctor->getAttribute('gender') !== null) {
                    $skippedAlreadySet++;

                    continue;
                }

                if ($execute) {
                    $snapshot->recordUpdate('doctors', $doctor->id, ['gender' => null]);
                    $doctor->forceFill(['gender' => $gender])->save();
                }

                $updated++;
            }
        });

        $path = null;
        if ($execute && ! $snapshot->isEmpty()) {
            $path = $snapshot->save();
        }

        return [
            'updated' => $updated,
            'skipped_already_set' => $skippedAlreadySet,
            'skipped_no_value' => $skippedNoValue,
            'snapshot' => $path,
        ];
    }

    /**
     * Null the `image` column for doctors whose stored path does not resolve
     * to a real file. The runtime fallback already renders correctly without
     * this - it only stops the database from asserting a file that isn't
     * there. Never touches a doctor whose image is already null or valid.
     *
     * @return array{fixed: int, snapshot: ?string}
     */
    public function fixImages(array $auditResult, bool $execute): array
    {
        $snapshot = new DoctorSyncSnapshot('fix-images');
        $fixed = 0;

        DB::transaction(function () use ($auditResult, $execute, $snapshot, &$fixed) {
            foreach ($auditResult['images']['broken'] as $row) {
                $doctor = Doctor::find($row['doctor_id']);

                if (! $doctor || $doctor->image === null) {
                    continue;
                }

                if ($execute) {
                    $snapshot->recordUpdate('doctors', $doctor->id, ['image' => $doctor->image]);
                    $doctor->forceFill(['image' => null])->save();
                }

                $fixed++;
            }
        });

        $path = ($execute && ! $snapshot->isEmpty()) ? $snapshot->save() : null;

        return ['fixed' => $fixed, 'snapshot' => $path];
    }

    /**
     * Null the known-fabricated email/phone values. Uses the flags the audit
     * already computed (`email_is_fabricated`/`phone_is_fabricated`) rather
     * than re-deriving them, so the report and the write agree exactly on
     * which values are fabricated.
     *
     * @return array{fixed_email: int, fixed_phone: int, snapshot: ?string}
     */
    public function fixContacts(array $auditResult, bool $execute): array
    {
        $snapshot = new DoctorSyncSnapshot('fix-contacts');
        $fixedEmail = 0;
        $fixedPhone = 0;

        DB::transaction(function () use ($auditResult, $execute, $snapshot, &$fixedEmail, &$fixedPhone) {
            foreach ($auditResult['doctors'] as $row) {
                if (! $row['email_is_fabricated'] && ! $row['phone_is_fabricated']) {
                    continue;
                }

                $doctor = Doctor::find($row['doctor_id']);

                if (! $doctor) {
                    continue;
                }

                $before = [];
                $updates = [];

                if ($row['email_is_fabricated'] && $doctor->email !== null) {
                    $before['email'] = $doctor->email;
                    $updates['email'] = null;
                    $fixedEmail++;
                }

                if ($row['phone_is_fabricated'] && $doctor->phone !== null) {
                    $before['phone'] = $doctor->phone;
                    $updates['phone'] = null;
                    $fixedPhone++;
                }

                if ($updates === []) {
                    continue;
                }

                if ($execute) {
                    $snapshot->recordUpdate('doctors', $doctor->id, $before);
                    $doctor->forceFill($updates)->save();
                }
            }
        });

        $path = ($execute && ! $snapshot->isEmpty()) ? $snapshot->save() : null;

        return ['fixed_email' => $fixedEmail, 'fixed_phone' => $fixedPhone, 'snapshot' => $path];
    }

    /**
     * Create the workbook profiles that have no database doctor. Always
     * inactive (status = false) with no branch schedule and no specialty/
     * department assignment, so they are invisible on the public site and
     * cannot be booked until an operator completes their record.
     *
     * The photo is only linked when an orphan file was matched to this
     * profile by SHA-256 in the read-only audit - never guessed by filename.
     *
     * @return array{created: array<int, array{name: string, id: ?int}>, snapshot: ?string}
     */
    public function createMissingDoctors(array $auditResult, bool $execute): array
    {
        $snapshot = new DoctorSyncSnapshot('create-missing-doctors');
        $created = [];

        DB::transaction(function () use ($auditResult, $execute, $snapshot, &$created) {
            foreach ($auditResult['unmatched_profiles'] as $profile) {
                $matchedImage = null;
                foreach ($auditResult['images']['orphan_files'] as $orphan) {
                    if ($orphan['matches_canonical_name'] === $profile['canonical']) {
                        $matchedImage = $orphan['path'];

                        break;
                    }
                }

                if (! $execute) {
                    $created[] = ['name' => $profile['name'], 'id' => null];

                    continue;
                }

                $doctor = Doctor::create([
                    'code' => doctor_code(),
                    'name' => $profile['name'],
                    'slug' => Str::slug($profile['name']).'-'.Str::lower(Str::random(6)),
                    'qualification' => $profile['qualification'],
                    'designation' => $profile['designation'],
                    'address' => 'Imperial Private Health Care BD Limited',
                    'image' => $matchedImage,
                    'commission' => 0,
                    'consultation_fee' => 0,
                    'video_consultation_available' => false,
                    'status' => false,
                ]);

                $snapshot->recordCreate('doctors', $doctor->id);
                $created[] = ['name' => $profile['name'], 'id' => $doctor->id];
            }
        });

        $path = ($execute && ! $snapshot->isEmpty()) ? $snapshot->save() : null;

        return ['created' => $created, 'snapshot' => $path];
    }

    /**
     * Fill blank/NULL profile fields (qualification, designation, bio,
     * address) from the workbook. A non-empty database value that conflicts
     * with the workbook is NEVER overwritten - it stays in the conflict report
     * for a human to resolve.
     *
     * @return array{filled: int, snapshot: ?string}
     */
    public function fillBlankProfileFields(array $auditResult, bool $execute): array
    {
        $snapshot = new DoctorSyncSnapshot('fill-blank-profile-fields');
        $filled = 0;

        DB::transaction(function () use ($auditResult, $execute, $snapshot, &$filled) {
            foreach ($auditResult['fillable_blanks'] as $row) {
                $doctor = Doctor::find($row['doctor_id']);

                if (! $doctor) {
                    continue;
                }

                $field = $row['field'];

                // Re-check the current value at write time - the read-only
                // audit result may be from an earlier moment in the same run.
                if ($doctor->{$field} !== null && trim((string) $doctor->{$field}) !== '') {
                    continue;
                }

                if ($execute) {
                    $snapshot->recordUpdate('doctors', $doctor->id, [$field => $doctor->{$field}]);
                    $doctor->forceFill([$field => $row['proposed_value']])->save();
                }

                $filled++;
            }
        });

        $path = ($execute && ! $snapshot->isEmpty()) ? $snapshot->save() : null;

        return ['filled' => $filled, 'snapshot' => $path];
    }

    /**
     * Apply the schedule diff. Writes only rows whose status the read-only
     * audit already classified as safe (WOULD_NORMALISE, MISSING_IN_DB, or a
     * previously-NEEDS_APPROVAL row now covered by an explicit manual
     * correction). Never touches PROTECTED_BY_BOOKINGS, AMBIGUOUS_DOCTOR,
     * UNMATCHED_DOCTOR, UNRESOLVED_BRANCH, or DUPLICATE_WORKBOOK_ROW rows.
     *
     * $manualCorrections lets specific, explicitly-approved (doctor_id,
     * branch_id) pairs override the normalizer's output - used for the two
     * invalid-time corrections, which are logged distinctly rather than
     * folded silently into the generic pass.
     *
     * @param  array<string, array{days: string, time: string}>  $manualCorrections  keyed "doctorId:branchId"
     * @return array{applied: int, corrected: int, already_current: int, skipped: int, snapshot: ?string}
     */
    public function syncSchedules(array $auditResult, bool $execute, array $manualCorrections = []): array
    {
        $snapshot = new DoctorSyncSnapshot('sync-schedules');
        $applied = 0;
        $corrected = 0;
        $skipped = 0;
        $alreadyCurrent = 0;

        $writableStatuses = ['WOULD_NORMALISE', 'MISSING_IN_DB', 'NEEDS_APPROVAL'];

        DB::transaction(function () use ($auditResult, $execute, $snapshot, $manualCorrections, $writableStatuses, &$applied, &$corrected, &$skipped, &$alreadyCurrent) {
            foreach ($auditResult['schedules'] as $row) {
                if (! in_array($row['status'], $writableStatuses, true)) {
                    $skipped++;

                    continue;
                }

                $key = $row['doctor_id'].':'.$row['branch_id'];
                $isManualCorrection = isset($manualCorrections[$key]);

                // A NEEDS_APPROVAL row is only writable if either it has an
                // explicit manual correction, or its normalized value is
                // itself valid (e.g. the Sat-to-Wed exclusion, or the Oncall/
                // Anyday/Everyday display labels - all approved as display
                // formatting). A row whose normalized value is still invalid
                // (e.g. an un-corrected bad time) and has no manual
                // correction is skipped, not guessed.
                if ($row['status'] === 'NEEDS_APPROVAL' && ! $isManualCorrection) {
                    $daysUsable = $row['days_proposed'] !== null;
                    $timeUsable = $row['time_proposed'] !== null && ! in_array('INVALID_TIME', $row['time_flags'], true);

                    if (! $daysUsable || ! $timeUsable) {
                        $skipped++;

                        continue;
                    }
                }

                // A manual correction may override only `time` (or only
                // `days`) - an absent OR explicitly-null override falls back
                // to the normalizer's own value rather than writing NULL.
                // The service does not trust a caller to have already applied
                // this fallback; it enforces it here regardless of caller.
                $manualDays = $isManualCorrection ? ($manualCorrections[$key]['days'] ?? null) : null;
                $manualTime = $isManualCorrection ? ($manualCorrections[$key]['time'] ?? null) : null;

                $days = $manualDays ?? $row['days_proposed'];
                $time = $manualTime ?? $row['time_proposed'];

                $existing = DoctorBranchSchedule::where('doctor_id', $row['doctor_id'])
                    ->where('branch_id', $row['branch_id'])
                    ->first();

                // A row whose classification (WOULD_NORMALISE / NEEDS_APPROVAL)
                // comes from the SOURCE TEXT rather than a live comparison can
                // stay in that state forever - e.g. an "Anyday" label is always
                // flagged, even after its normalized value has already been
                // written. Comparing against the row actually about to be
                // persisted (which folds in any manual correction) is what
                // makes a second run genuinely idempotent instead of
                // re-writing an unchanged value and adding rollback-snapshot
                // noise on every invocation.
                if ($existing
                    && $existing->consultant === $row['consultant']
                    && $existing->schedule_days === $days
                    && $existing->schedule_time === $time
                ) {
                    $alreadyCurrent++;

                    continue;
                }

                if ($execute) {
                    if ($existing) {
                        $snapshot->recordUpdate('doctor_branch_schedules', $existing->id, [
                            'consultant' => $existing->consultant,
                            'schedule_days' => $existing->schedule_days,
                            'schedule_time' => $existing->schedule_time,
                        ]);
                        $existing->forceFill([
                            'consultant' => $row['consultant'],
                            'schedule_days' => $days,
                            'schedule_time' => $time,
                        ])->save();
                    } else {
                        $new = DoctorBranchSchedule::create([
                            'doctor_id' => $row['doctor_id'],
                            'branch_id' => $row['branch_id'],
                            'consultant' => $row['consultant'],
                            'schedule_days' => $days,
                            'schedule_time' => $time,
                        ]);
                        $snapshot->recordCreate('doctor_branch_schedules', $new->id);
                    }
                }

                $isManualCorrection ? $corrected++ : $applied++;
            }
        });

        $path = ($execute && ! $snapshot->isEmpty()) ? $snapshot->save() : null;

        return [
            'applied' => $applied,
            'corrected' => $corrected,
            'already_current' => $alreadyCurrent,
            'skipped' => $skipped,
            'snapshot' => $path,
        ];
    }

    /**
     * Gate E: create a specialty/department pair if missing and reassign one
     * doctor to it. A narrow, named operation rather than a generic mapper -
     * this correction was individually reviewed and approved, not derived
     * from a bulk rule.
     *
     * @return array{specialty_id: ?int, department_id: ?int, doctor_updated: bool, snapshot: ?string}
     */
    public function reassignSpecialty(string $doctorCanonicalName, string $specialtyName, string $departmentName, array $auditResult, bool $execute): array
    {
        $snapshot = new DoctorSyncSnapshot('reassign-specialty');

        $doctorRow = null;
        foreach ($auditResult['doctors'] as $row) {
            if ($row['canonical'] === $doctorCanonicalName) {
                $doctorRow = $row;

                break;
            }
        }

        if ($doctorRow === null) {
            return ['specialty_id' => null, 'department_id' => null, 'doctor_updated' => false, 'snapshot' => null];
        }

        $specialtyId = null;
        $departmentId = null;
        $doctorUpdated = false;

        DB::transaction(function () use ($doctorRow, $specialtyName, $departmentName, $execute, $snapshot, &$specialtyId, &$departmentId, &$doctorUpdated) {
            $specialty = DoctorSpecialty::where('name', $specialtyName)->first();
            $department = DoctorDepartment::where('name', $departmentName)->first();

            if (! $execute) {
                $specialtyId = optional($specialty)->id;
                $departmentId = optional($department)->id;
                $doctorUpdated = true;

                return;
            }

            if (! $specialty) {
                $specialty = DoctorSpecialty::create([
                    'name' => $specialtyName,
                    'slug' => Str::slug($specialtyName),
                    'status' => true,
                    'sort_order' => 0,
                ]);
                $snapshot->recordCreate('doctor_specialties', $specialty->id);
            }

            if (! $department) {
                $department = DoctorDepartment::create([
                    'name' => $departmentName,
                    'slug' => Str::slug($departmentName),
                    'status' => true,
                    'sort_order' => 0,
                ]);
                $snapshot->recordCreate('doctor_departments', $department->id);
            }

            $doctor = Doctor::find($doctorRow['doctor_id']);

            // Skip the write (and the snapshot) if the doctor already has
            // this exact specialty/department - otherwise every re-run would
            // re-save the row and produce a new rollback snapshot for a
            // change that already happened, the same idempotency gap fixed
            // in syncSchedules().
            if ($doctor
                && (int) $doctor->doctor_specialty_id === (int) $specialty->id
                && (int) $doctor->doctor_department_id === (int) $department->id
            ) {
                $doctorUpdated = false;
            } elseif ($doctor) {
                $snapshot->recordUpdate('doctors', $doctor->id, [
                    'doctor_specialty_id' => $doctor->doctor_specialty_id,
                    'doctor_department_id' => $doctor->doctor_department_id,
                ]);
                $doctor->forceFill([
                    'doctor_specialty_id' => $specialty->id,
                    'doctor_department_id' => $department->id,
                ])->save();
                $doctorUpdated = true;
            }

            $specialtyId = $specialty->id;
            $departmentId = $department->id;
        });

        $path = ($execute && ! $snapshot->isEmpty()) ? $snapshot->save() : null;

        return [
            'specialty_id' => $specialtyId,
            'department_id' => $departmentId,
            'doctor_updated' => $doctorUpdated,
            'snapshot' => $path,
        ];
    }
}
