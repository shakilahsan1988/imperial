<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorBranchSchedule;
use App\Models\DoctorDepartment;
use App\Models\DoctorSpecialty;
use App\Services\DoctorAuditService;
use App\Services\DoctorSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

/**
 * The write side of Gates B-E. Every write here must be idempotent, must
 * never overwrite a value already set by someone else, and must produce a
 * usable rollback snapshot whenever it actually changes something.
 */
class DoctorSyncServiceTest extends TestCase
{
    use RefreshDatabase;

    private DoctorSyncService $sync;

    private DoctorAuditService $audit;

    private string $sourceDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sync = new DoctorSyncService;
        $this->audit = new DoctorAuditService;
        $this->sourceDir = storage_path('framework/testing/doctor-sync-fixture-'.uniqid());
        File::ensureDirectoryExists($this->sourceDir.'/images');
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->sourceDir);

        foreach (Doctor::withTrashed()->pluck('id') as $id) {
            File::deleteDirectory(public_path('uploads/doctors/'.$id));
        }

        parent::tearDown();
    }

    private function writeProfileWorkbook(array $rows): void
    {
        $sheet = new Spreadsheet;
        $active = $sheet->getActiveSheet();
        $active->fromArray([[null, null, 'Doctor Name', 'Qualification', 'Designation', 'Hospital', 'Short Description']], null, 'A1');

        foreach ($rows as $i => $row) {
            $active->fromArray([array_merge([null, null], $row)], null, 'A'.($i + 2));
        }

        (new Xlsx($sheet))->save($this->sourceDir.'/doctors.xlsx');
    }

    private function writeScheduleWorkbook(string $filename, string $branchLabel, array $rows): void
    {
        $sheet = new Spreadsheet;
        $active = $sheet->getActiveSheet();
        $active->setCellValue('A1', 'Imperial Private Healthcare (BD) LTD.');
        $active->setCellValue('A2', 'Doctors Schedule');
        $active->setCellValue('A3', 'Branch : '.$branchLabel);
        $active->fromArray([['SL No', 'Name', 'Consultant', 'Day', 'Time']], null, 'A4');

        foreach ($rows as $i => $row) {
            $active->fromArray([array_merge([$i + 1], $row)], null, 'A'.($i + 5));
        }

        (new Xlsx($sheet))->save($this->sourceDir.'/'.$filename);
    }

    /** proposeGender only proposes values present in the curated map - never guesses for an unmapped name. */
    public function test_propose_gender_uses_curated_map_only(): void
    {
        $mapped = Doctor::factory()->create(['name' => 'Dr. Akil Al Islam']);
        $unmapped = Doctor::factory()->create(['name' => 'Dr. Some Unlisted Person']);

        $auditResult = ['doctors' => [
            ['doctor_id' => $mapped->id, 'name' => $mapped->name, 'canonical' => 'akil al islam'],
            ['doctor_id' => $unmapped->id, 'name' => $unmapped->name, 'canonical' => 'some unlisted person'],
        ], 'unmatched_profiles' => []];

        $rows = $this->sync->proposeGender($auditResult);

        $byId = collect($rows)->keyBy('doctor_id');
        $this->assertSame('male', $byId[$mapped->id]['proposed_gender']);
        $this->assertSame('yes', $byId[$mapped->id]['in_curated_map']);
        $this->assertNull($byId[$unmapped->id]['proposed_gender']);
        $this->assertSame('no', $byId[$unmapped->id]['in_curated_map']);
    }

    /** applyGender writes gender for a doctor whose gender is currently null. */
    public function test_apply_gender_writes_when_currently_null(): void
    {
        $doctor = Doctor::factory()->create(['name' => 'Dr. Marufa Shahrin']);

        $outcome = $this->sync->applyGender([
            ['doctor_id' => $doctor->id, 'proposed_gender' => 'female'],
        ], true);

        $this->assertSame(1, $outcome['updated']);
        $this->assertNotNull($outcome['snapshot']);
        $this->assertSame('female', $doctor->fresh()->gender);
    }

    /** applyGender never overwrites a gender that is already set - proves idempotency and protects manual admin edits. */
    public function test_apply_gender_never_overwrites_an_existing_value(): void
    {
        $doctor = Doctor::factory()->create(['gender' => 'male']);

        $outcome = $this->sync->applyGender([
            ['doctor_id' => $doctor->id, 'proposed_gender' => 'female'],
        ], true);

        $this->assertSame(0, $outcome['updated']);
        $this->assertSame(1, $outcome['skipped_already_set']);
        $this->assertSame('male', $doctor->fresh()->gender, 'An already-set gender must never be overwritten.');
    }

    /** Dry run changes nothing. */
    public function test_apply_gender_dry_run_writes_nothing(): void
    {
        $doctor = Doctor::factory()->create();

        $this->sync->applyGender([['doctor_id' => $doctor->id, 'proposed_gender' => 'male']], false);

        $this->assertNull($doctor->fresh()->gender);
    }

    /** A row with an invalid gender value or a missing doctor is skipped, not applied. */
    public function test_apply_gender_skips_invalid_rows(): void
    {
        $doctor = Doctor::factory()->create();

        $outcome = $this->sync->applyGender([
            ['doctor_id' => $doctor->id, 'proposed_gender' => 'not-a-real-gender'],
            ['doctor_id' => 999999, 'proposed_gender' => 'male'],
            ['doctor_id' => null, 'proposed_gender' => 'male'],
        ], true);

        $this->assertSame(0, $outcome['updated']);
        $this->assertSame(3, $outcome['skipped_no_value']);
    }

    /** fixImages nulls a broken path but leaves a doctor with no image untouched. */
    public function test_fix_images_only_touches_broken_paths(): void
    {
        $broken = Doctor::factory()->create(['image' => 'uploads/doctors/999/missing.jpg']);
        $clean = Doctor::factory()->create(['image' => null]);

        $auditResult = ['images' => ['broken' => [
            ['doctor_id' => $broken->id],
        ]]];

        $outcome = $this->sync->fixImages($auditResult, true);

        $this->assertSame(1, $outcome['fixed']);
        $this->assertNull($broken->fresh()->image);
        $this->assertNull($clean->fresh()->image);
    }

    /** fixContacts nulls only the fields the audit flagged as fabricated, leaving real values alone. */
    public function test_fix_contacts_only_nulls_fabricated_values(): void
    {
        $fabricated = Doctor::factory()->create(['email' => 'doctor@iphcbd.com', 'phone' => '01332556541']);
        $real = Doctor::factory()->create(['email' => 'real.doctor@example.com', 'phone' => '01799999999']);

        $auditResult = ['doctors' => [
            ['doctor_id' => $fabricated->id, 'email_is_fabricated' => true, 'phone_is_fabricated' => true],
            ['doctor_id' => $real->id, 'email_is_fabricated' => false, 'phone_is_fabricated' => false],
        ]];

        $outcome = $this->sync->fixContacts($auditResult, true);

        $this->assertSame(1, $outcome['fixed_email']);
        $this->assertSame(1, $outcome['fixed_phone']);
        $this->assertNull($fabricated->fresh()->email);
        $this->assertNull($fabricated->fresh()->phone);
        $this->assertSame('real.doctor@example.com', $real->fresh()->email);
        $this->assertSame('01799999999', $real->fresh()->phone);
    }

    /** createMissingDoctors creates an inactive doctor with no schedule, linked to its matched photo. */
    public function test_create_missing_doctors_creates_inactive_with_matched_photo(): void
    {
        $auditResult = [
            'unmatched_profiles' => [[
                'name' => 'Dr. New Person',
                'canonical' => 'new person',
                'qualification' => 'MBBS',
                'designation' => 'Consultant',
            ]],
            'images' => ['orphan_files' => [
                ['path' => 'uploads/doctors/dr-new-person.jpg', 'matches_canonical_name' => 'new person'],
            ]],
        ];

        $outcome = $this->sync->createMissingDoctors($auditResult, true);

        $this->assertCount(1, $outcome['created']);
        $id = $outcome['created'][0]['id'];
        $doctor = Doctor::find($id);

        $this->assertNotNull($doctor);
        $this->assertFalse((bool) $doctor->status, 'A newly created profile-only doctor must be inactive.');
        $this->assertSame('uploads/doctors/dr-new-person.jpg', $doctor->image);
        $this->assertNull($doctor->doctor_specialty_id);
        $this->assertSame(0, DoctorBranchSchedule::where('doctor_id', $doctor->id)->count());
    }

    /**
     * Idempotency for --create-missing is achieved by the COMMAND re-running
     * the read-only audit before every write, not by the service deduping -
     * once a doctor exists, a fresh audit() naturally stops listing their
     * profile as unmatched. Proven end to end here with real workbook
     * fixtures, the same way the command actually calls both services.
     */
    public function test_create_missing_doctors_becomes_a_no_op_once_the_doctor_exists(): void
    {
        Branch::factory()->hatirpool()->create();

        $this->writeProfileWorkbook([
            ['Dr. New Person', 'MBBS', 'Consultant', 'Imperial Private Health Care BD Limited', ''],
        ]);
        $this->writeScheduleWorkbook('Doctors Schedule Hatirpol.xlsx', 'Hatirpool Branch', []);

        $firstAudit = $this->audit->audit($this->sourceDir);
        $this->assertCount(1, $firstAudit['unmatched_profiles']);

        $this->sync->createMissingDoctors($firstAudit, true);
        $this->assertSame(1, Doctor::count());

        $secondAudit = $this->audit->audit($this->sourceDir);
        $this->assertCount(0, $secondAudit['unmatched_profiles'], 'The newly created doctor must no longer be reported as unmatched.');

        $this->sync->createMissingDoctors($secondAudit, true);
        $this->assertSame(1, Doctor::count(), 'Re-running against a fresh audit must not create a duplicate.');
    }

    /** fillBlankProfileFields fills only NULL/blank fields, never a conflicting non-empty value. */
    public function test_fill_blank_profile_fields_never_overwrites_a_conflict(): void
    {
        $blank = Doctor::factory()->create(['qualification' => null]);
        $conflict = Doctor::factory()->create(['qualification' => 'Existing Real Value']);

        $auditResult = ['fillable_blanks' => [
            ['doctor_id' => $blank->id, 'field' => 'qualification', 'proposed_value' => 'MBBS'],
        ]];

        $outcome = $this->sync->fillBlankProfileFields($auditResult, true);

        $this->assertSame(1, $outcome['filled']);
        $this->assertSame('MBBS', $blank->fresh()->qualification);
        $this->assertSame('Existing Real Value', $conflict->fresh()->qualification, 'A field never proposed as fillable must never change.');
    }

    /** syncSchedules writes WOULD_NORMALISE rows and skips protected/ambiguous ones. */
    public function test_sync_schedules_applies_safe_rows_and_skips_protected(): void
    {
        $doctor = Doctor::factory()->create();
        $branch = Branch::factory()->create();

        $auditResult = ['schedules' => [
            [
                'status' => 'WOULD_NORMALISE', 'doctor_id' => $doctor->id, 'branch_id' => $branch->id,
                'consultant' => 'Medicine', 'days_proposed' => 'Sat, Mon, Wed', 'time_proposed' => '10:00 AM - 01:00 PM',
                'time_flags' => [],
            ],
            [
                'status' => 'PROTECTED_BY_BOOKINGS', 'doctor_id' => $doctor->id, 'branch_id' => $branch->id + 1,
                'consultant' => 'Medicine', 'days_proposed' => 'Sun', 'time_proposed' => '10:00 AM - 01:00 PM',
                'time_flags' => [],
            ],
        ]];

        $outcome = $this->sync->syncSchedules($auditResult, true);

        $this->assertSame(1, $outcome['applied']);
        $this->assertSame(1, $outcome['skipped']);

        $schedule = DoctorBranchSchedule::where('doctor_id', $doctor->id)->where('branch_id', $branch->id)->first();
        $this->assertNotNull($schedule);
        $this->assertSame('Sat, Mon, Wed', $schedule->schedule_days);
    }

    /** An un-corrected INVALID_TIME row is skipped, never guessed at. */
    public function test_sync_schedules_skips_uncorrected_invalid_time(): void
    {
        $doctor = Doctor::factory()->create();
        $branch = Branch::factory()->create();

        $auditResult = ['schedules' => [[
            'status' => 'NEEDS_APPROVAL', 'doctor_id' => $doctor->id, 'branch_id' => $branch->id,
            'consultant' => 'Cardiology', 'days_proposed' => 'Sun, Thu',
            'time_proposed' => '11:00 PM - 01:30 PM', 'time_flags' => ['INVALID_TIME'],
        ]]];

        $outcome = $this->sync->syncSchedules($auditResult, true);

        $this->assertSame(0, $outcome['applied']);
        $this->assertSame(0, $outcome['corrected']);
        $this->assertSame(1, $outcome['skipped']);
        $this->assertSame(0, DoctorBranchSchedule::count());
    }

    /** An explicit manual correction is applied and counted separately from generic normalization. */
    public function test_sync_schedules_applies_manual_correction_for_invalid_time(): void
    {
        $doctor = Doctor::factory()->create();
        $branch = Branch::factory()->create();

        $auditResult = ['schedules' => [[
            'status' => 'NEEDS_APPROVAL', 'doctor_id' => $doctor->id, 'branch_id' => $branch->id,
            'consultant' => 'Cardiology', 'days_proposed' => 'Sun, Thu',
            'time_proposed' => '11:00 PM - 01:30 PM', 'time_flags' => ['INVALID_TIME'],
        ]]];

        $key = $doctor->id.':'.$branch->id;
        $outcome = $this->sync->syncSchedules($auditResult, true, [
            $key => ['days' => null, 'time' => '11:00 AM - 01:30 PM'],
        ]);

        $this->assertSame(1, $outcome['corrected']);
        $schedule = DoctorBranchSchedule::where('doctor_id', $doctor->id)->where('branch_id', $branch->id)->first();
        $this->assertSame('11:00 AM - 01:30 PM', $schedule->schedule_time);
        $this->assertSame('Sun, Thu', $schedule->schedule_days, 'Days must fall back to the normalizer output when the manual correction only overrides time.');
    }

    /** Re-running syncSchedules on an unchanged diff does not duplicate rows. */
    public function test_sync_schedules_is_idempotent(): void
    {
        $doctor = Doctor::factory()->create();
        $branch = Branch::factory()->create();

        $auditResult = ['schedules' => [[
            'status' => 'WOULD_NORMALISE', 'doctor_id' => $doctor->id, 'branch_id' => $branch->id,
            'consultant' => 'Medicine', 'days_proposed' => 'Sat, Mon', 'time_proposed' => '10:00 AM - 01:00 PM',
            'time_flags' => [],
        ]]];

        $this->sync->syncSchedules($auditResult, true);
        $this->sync->syncSchedules($auditResult, true);

        $this->assertSame(1, DoctorBranchSchedule::where('doctor_id', $doctor->id)->where('branch_id', $branch->id)->count());
    }

    /**
     * A row whose status is NEEDS_APPROVAL because of its SOURCE TEXT (e.g.
     * "Anyday") stays classified NEEDS_APPROVAL forever - that classification
     * doesn't flip to UP_TO_DATE just because the DB now matches. Without a
     * live before/after comparison in the write path, such a row would be
     * silently re-saved (and re-snapshotted) on every single run. This is a
     * regression test for that bug: the second run must report the row as
     * already_current and must not touch updated_at.
     */
    public function test_sync_schedules_is_idempotent_for_a_permanently_flagged_row(): void
    {
        $doctor = Doctor::factory()->create();
        $branch = Branch::factory()->create();

        $auditResult = ['schedules' => [[
            'status' => 'NEEDS_APPROVAL', 'doctor_id' => $doctor->id, 'branch_id' => $branch->id,
            'consultant' => 'ENT', 'days_proposed' => 'Sat, Sun, Mon, Tue, Wed, Thu, Fri',
            'time_proposed' => 'On Call', 'time_flags' => ['ONCALL'],
        ]]];

        $first = $this->sync->syncSchedules($auditResult, true);
        $this->assertSame(1, $first['applied']);

        $schedule = DoctorBranchSchedule::where('doctor_id', $doctor->id)->where('branch_id', $branch->id)->first();
        $firstUpdatedAt = $schedule->updated_at;

        $second = $this->sync->syncSchedules($auditResult, true);

        $this->assertSame(0, $second['applied'], 'A row already matching the DB must not be re-applied, even if its status is permanently NEEDS_APPROVAL.');
        $this->assertSame(1, $second['already_current']);
        $this->assertNull($second['snapshot'], 'A run that changes nothing must not produce a rollback snapshot.');
        $this->assertEquals($firstUpdatedAt, $schedule->fresh()->updated_at, 'An unchanged row must not be re-saved.');
    }

    /** reassignSpecialty creates the specialty/department pair once and reassigns the doctor. */
    public function test_reassign_specialty_creates_rows_and_reassigns_doctor(): void
    {
        $doctor = Doctor::factory()->create(['name' => 'Dr. Md. Mahfuzur Rahman']);

        $auditResult = ['doctors' => [
            ['doctor_id' => $doctor->id, 'canonical' => 'md mahfuzur rahman'],
        ]];

        $outcome = $this->sync->reassignSpecialty(
            'md mahfuzur rahman', 'Oral & Maxillofacial Surgery', 'Oral & Maxillofacial Surgery', $auditResult, true
        );

        $this->assertNotNull($outcome['specialty_id']);
        $this->assertNotNull($outcome['department_id']);
        $this->assertTrue($outcome['doctor_updated']);

        $doctor->refresh();
        $this->assertSame($outcome['specialty_id'], $doctor->doctor_specialty_id);
        $this->assertSame($outcome['department_id'], $doctor->doctor_department_id);
        $this->assertSame(1, DoctorSpecialty::where('name', 'Oral & Maxillofacial Surgery')->count());
    }

    /** Running the specialty reassignment twice does not create a duplicate specialty/department row. */
    public function test_reassign_specialty_is_idempotent(): void
    {
        $doctor = Doctor::factory()->create(['name' => 'Dr. Md. Mahfuzur Rahman']);
        $auditResult = ['doctors' => [['doctor_id' => $doctor->id, 'canonical' => 'md mahfuzur rahman']]];

        $first = $this->sync->reassignSpecialty('md mahfuzur rahman', 'Oral & Maxillofacial Surgery', 'Oral & Maxillofacial Surgery', $auditResult, true);
        $doctor->refresh();
        $firstUpdatedAt = $doctor->updated_at;

        $second = $this->sync->reassignSpecialty('md mahfuzur rahman', 'Oral & Maxillofacial Surgery', 'Oral & Maxillofacial Surgery', $auditResult, true);

        $this->assertSame(1, DoctorSpecialty::where('name', 'Oral & Maxillofacial Surgery')->count());
        $this->assertSame(1, DoctorDepartment::where('name', 'Oral & Maxillofacial Surgery')->count());
        $this->assertFalse($second['doctor_updated'], 'A doctor already assigned to the target specialty must not be re-saved.');
        $this->assertNull($second['snapshot'], 'A run that changes nothing must not produce a rollback snapshot.');
        $this->assertEquals($firstUpdatedAt, $doctor->fresh()->updated_at);
    }
}
