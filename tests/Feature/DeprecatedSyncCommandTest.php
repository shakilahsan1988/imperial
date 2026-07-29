<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Services\DoctorDataSyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test 19a: the old destructive command must fail safely and change nothing,
 * rather than being deleted outright (plan correction #2). This is what makes
 * "retained for reference, not executable" an actual guarantee instead of a
 * comment.
 */
class DeprecatedSyncCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_source_command_fails_and_changes_nothing(): void
    {
        Doctor::factory()->count(3)->create();

        $exitCode = $this->artisan('doctor:sync-source', ['sourceDir' => 'irrelevant'])->run();

        $this->assertNotSame(0, $exitCode, 'The deprecated command must not report success.');
        $this->assertSame(3, Doctor::count(), 'The deprecated command must not touch any doctor row.');
    }

    public function test_service_sync_from_directory_throws_before_doing_anything(): void
    {
        Doctor::factory()->count(2)->create();

        $service = new DoctorDataSyncService;

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(DoctorDataSyncService::DEPRECATION_MESSAGE);

        try {
            $service->syncFromDirectory('irrelevant');
        } finally {
            $this->assertSame(2, Doctor::count(), 'No doctor may be deleted even though the guard threw.');
        }
    }

    public function test_service_purge_throws_before_truncating_anything(): void
    {
        Doctor::factory()->count(2)->create();

        $service = new DoctorDataSyncService;

        $this->expectException(\RuntimeException::class);

        try {
            $service->purgeApplicationData();
        } finally {
            $this->assertSame(2, Doctor::count());
        }
    }
}
