<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Doctor;
use App\Services\DoctorAuditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

/**
 * The audit command is read-only end to end: no --execute flag exists yet.
 * These tests build a small, self-contained source directory rather than
 * depending on the external "d:\work\..." folder, so they run anywhere.
 *
 * Covers plan tests 9 (duplicate imports prevented - here: read twice, no
 * duplication of findings), 10 (ambiguous matches skipped, never guessed) and
 * 19 (re-running produces the same result, since nothing is written).
 */
class DoctorAuditCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $sourceDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sourceDir = storage_path('framework/testing/doctor-audit-fixture-'.uniqid());
        File::ensureDirectoryExists($this->sourceDir.'/images');
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->sourceDir);

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

    public function test_ambiguous_doctor_matches_are_reported_and_never_guessed(): void
    {
        Branch::factory()->hatirpool()->create();

        // Two database doctors normalise to the same name - the audit must
        // never pick one over the other.
        Doctor::factory()->create(['name' => 'Dr. Sameer Islam']);
        Doctor::factory()->create(['name' => 'Dr. Sameer Islam']);

        $this->writeProfileWorkbook([
            ['Dr. Sameer Islam', 'MBBS', 'Consultant - Medicine', 'Imperial Private Health Care BD Limited', ''],
        ]);
        $this->writeScheduleWorkbook('Doctors Schedule Hatirpol.xlsx', 'Hatirpool Branch', [
            ['Dr. Sameer Islam', 'Medicine', 'Monday', '10am - 01pm'],
        ]);

        $result = (new DoctorAuditService)->audit($this->sourceDir);

        $ambiguousTypes = array_column($result['ambiguous'], 'type');

        $this->assertContains('SCHEDULE_DOCTOR', $ambiguousTypes);
        $this->assertContains('DOCTOR_PROFILE', $ambiguousTypes);

        // And nothing was written.
        $this->assertSame(2, Doctor::count());
    }

    public function test_branches_are_resolved_by_name_not_hard_coded_id(): void
    {
        // Deliberately create the branch with a HIGH id, proving nothing in
        // the audit assumes Hatirpool is id 5.
        $branch = Branch::factory()->hatirpool()->create(['id' => 777]);

        $this->writeProfileWorkbook([
            ['Dr. Name Here', 'MBBS', 'Consultant - Medicine', 'Imperial Private Health Care BD Limited', ''],
        ]);
        $this->writeScheduleWorkbook('Doctors Schedule Hatirpol.xlsx', 'Hatirpool Branch', [
            ['Dr. Name Here', 'Medicine', 'Monday', '10am - 01pm'],
        ]);

        Doctor::factory()->create(['name' => 'Dr. Name Here']);

        $result = (new DoctorAuditService)->audit($this->sourceDir);

        $this->assertEmpty($result['branches']['unresolved']);
        $this->assertSame($branch->id, $result['schedules'][0]['branch_id']);
    }

    public function test_an_unresolvable_branch_is_a_hard_error_never_a_guess(): void
    {
        // No branch exists at all, so "Some Unknown Place" cannot resolve.
        $this->writeProfileWorkbook([
            ['Dr. Name Here', 'MBBS', 'Consultant - Medicine', 'Imperial Private Health Care BD Limited', ''],
        ]);
        $this->writeScheduleWorkbook('Doctors Schedule Unknown.xlsx', 'Some Unknown Place', [
            ['Dr. Name Here', 'Medicine', 'Monday', '10am - 01pm'],
        ]);

        $result = (new DoctorAuditService)->audit($this->sourceDir);

        $this->assertNotEmpty($result['branches']['unresolved']);
        $this->assertSame('UNRESOLVED_BRANCH', $result['schedules'][0]['status']);
    }

    /** Test 19 (adapted): running the read-only audit twice produces byte-identical findings, since nothing is written between runs. */
    public function test_running_the_audit_twice_produces_the_same_result(): void
    {
        Branch::factory()->hatirpool()->create();
        Doctor::factory()->create(['name' => 'Dr. Repeat Runner']);

        $this->writeProfileWorkbook([
            ['Dr. Repeat Runner', 'MBBS', 'Consultant - Medicine', 'Imperial Private Health Care BD Limited', ''],
        ]);
        $this->writeScheduleWorkbook('Doctors Schedule Hatirpol.xlsx', 'Hatirpool Branch', [
            ['Dr. Repeat Runner', 'Medicine', 'Monday', '10am - 01pm'],
        ]);

        $service = new DoctorAuditService;
        $first = $service->audit($this->sourceDir);
        $second = $service->audit($this->sourceDir);

        unset($first['environment']['generated_at'], $second['environment']['generated_at']);

        $this->assertSame($first['counts'], $second['counts']);
        $this->assertSame($first['schedules'], $second['schedules']);
        $this->assertSame(1, Doctor::count(), 'Re-running a read-only audit must never create a duplicate doctor.');
    }

    public function test_missing_source_directory_is_a_clear_error(): void
    {
        $this->expectException(\RuntimeException::class);

        (new DoctorAuditService)->audit(storage_path('framework/testing/does-not-exist-'.uniqid()));
    }

    public function test_audit_never_writes_to_the_database(): void
    {
        Branch::factory()->hatirpool()->create();

        // The factory default qualification is 'MBBS'; the workbook proposes
        // a conflicting value. A read-only audit must leave the factory value
        // exactly as it was, never overwritten with the workbook's.
        $doctor = Doctor::factory()->create(['name' => 'Dr. Untouched']);
        $originalUpdatedAt = $doctor->updated_at;
        $this->assertSame('MBBS', $doctor->qualification);

        $this->writeProfileWorkbook([
            ['Dr. Untouched', 'MBBS, Updated Degree', 'New Designation', 'Imperial Private Health Care BD Limited', 'New bio'],
        ]);
        $this->writeScheduleWorkbook('Doctors Schedule Hatirpol.xlsx', 'Hatirpool Branch', [
            ['Dr. Untouched', 'Medicine', 'Monday', '10am - 01pm'],
        ]);

        $result = (new DoctorAuditService)->audit($this->sourceDir);

        $doctor->refresh();

        // The conflict must be REPORTED, which is proof the audit noticed the
        // difference - and simultaneously proof it did not act on it.
        $this->assertNotEmpty($result['conflicts']);

        $this->assertSame(1, Doctor::count());
        $this->assertSame('MBBS', $doctor->qualification, 'A conflicting field must not be written by a read-only audit.');
        $this->assertEquals($originalUpdatedAt, $doctor->updated_at);
    }
}
