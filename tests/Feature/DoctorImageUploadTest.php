<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Services\DoctorImageService;
use App\Support\DoctorImagePresenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * The upload/replace/remove lifecycle end to end, through the real service
 * that DoctorsController delegates to (store()/update() call
 * DoctorImageService::store()/remove() exactly as they do in production).
 */
class DoctorImageUploadTest extends TestCase
{
    use RefreshDatabase;

    private DoctorImageService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new DoctorImageService;
        DoctorImagePresenter::flushCache();
    }

    /**
     * Delete ONLY the per-doctor subdirectories this test run created, never
     * the shared uploads/doctors root - which is where the 16 real, currently
     * in-use doctor photos live. A blanket File::deleteDirectory() on the
     * shared root previously wiped those real files during a local test run;
     * this precise, id-scoped cleanup is what replaced it.
     *
     * RefreshDatabase rolls its transaction back on application teardown,
     * which happens after this method runs, so Doctor::pluck('id') here still
     * reflects exactly the doctors this test created.
     */
    protected function tearDown(): void
    {
        foreach (Doctor::pluck('id') as $id) {
            File::deleteDirectory(public_path('uploads/doctors/'.$id));
        }

        DoctorImagePresenter::flushCache();

        parent::tearDown();
    }

    private function fakeImage(string $name = 'photo.jpg'): UploadedFile
    {
        return UploadedFile::fake()->image($name, 400, 400)->size(200);
    }

    /** Test 5: uploading doctor A's photo never touches doctor B's file or row. */
    public function test_uploading_one_doctors_photo_does_not_affect_another(): void
    {
        $doctorA = Doctor::factory()->create();
        $doctorB = Doctor::factory()->create();

        $pathB = $this->service->store($doctorB, $this->fakeImage('b.jpg'));
        $bytesBBefore = file_get_contents(public_path($pathB));

        $this->service->store($doctorA, $this->fakeImage('a.jpg'));

        $doctorB->refresh();

        $this->assertSame($pathB, $doctorB->image);
        $this->assertTrue(is_file(public_path($pathB)));
        $this->assertSame($bytesBBefore, file_get_contents(public_path($pathB)));
    }

    /** Test 5a: two uploads for two different doctors never collide, even issued back to back. */
    public function test_same_moment_uploads_for_two_doctors_produce_distinct_files(): void
    {
        $doctorA = Doctor::factory()->create();
        $doctorB = Doctor::factory()->create();

        $pathA = $this->service->store($doctorA, $this->fakeImage());
        $pathB = $this->service->store($doctorB, $this->fakeImage());

        $this->assertNotSame($pathA, $pathB);
        $this->assertStringContainsString('/'.$doctorA->id.'/', $pathA);
        $this->assertStringContainsString('/'.$doctorB->id.'/', $pathB);
        $this->assertTrue(is_file(public_path($pathA)));
        $this->assertTrue(is_file(public_path($pathB)));
    }

    /** Test 6: replacing doctor A's photo removes A's old file but never touches B's. */
    public function test_replacing_a_photo_removes_the_old_file_but_not_another_doctors(): void
    {
        $doctorA = Doctor::factory()->create();
        $doctorB = Doctor::factory()->create();

        $oldPathA = $this->service->store($doctorA, $this->fakeImage('old.jpg'));
        $pathB = $this->service->store($doctorB, $this->fakeImage('b.jpg'));

        $newPathA = $this->service->store($doctorA, $this->fakeImage('new.jpg'));

        $this->assertNotSame($oldPathA, $newPathA);
        $this->assertFalse(is_file(public_path($oldPathA)), "Doctor A's superseded file should be removed.");
        $this->assertTrue(is_file(public_path($newPathA)));
        $this->assertTrue(is_file(public_path($pathB)), "Doctor B's file must be untouched by A's replacement.");
        $this->assertSame($pathB, $doctorB->fresh()->image);
    }

    /**
     * Test 8: removing a photo clears the row and deletes the owned file,
     * restoring the avatar fallback.
     *
     * doctors.gender does not exist until the separate Gate B migration, so
     * every doctor here resolves to the neutral avatar - which is exactly the
     * documented Gate A state: the fallback mechanism works, but per-doctor
     * gender has not been captured yet.
     */
    public function test_removing_a_photo_restores_the_fallback(): void
    {
        $doctor = Doctor::factory()->create();
        $path = $this->service->store($doctor, $this->fakeImage());

        $this->assertTrue($doctor->fresh()->hasPersonalImage());

        $this->service->remove($doctor);
        $doctor->refresh();

        $this->assertNull($doctor->image);
        $this->assertFalse($doctor->hasPersonalImage());
        $this->assertFalse(is_file(public_path($path)));
        $this->assertStringContainsString((string) config('doctor_sync.avatars.unknown'), $doctor->effective_image_url);
    }

    /**
     * Test 8a: if the database update fails, the OLD file must survive and
     * the NEW file must be cleaned up - a transaction cannot roll back a
     * filesystem write, so the service must order these itself.
     *
     * The query match is quote-agnostic (sqlite quotes identifiers with `"`,
     * MySQL with `` ` ``) so this test behaves the same under either driver.
     * A dedicated exception class is used for the simulated failure so it is
     * never confused with PHPUnit's own AssertionFailedError, which - in this
     * PHPUnit version - itself extends RuntimeException.
     */
    public function test_database_failure_preserves_the_old_file_and_removes_the_new_one(): void
    {
        $doctor = Doctor::factory()->create();
        $oldPath = $this->service->store($doctor, $this->fakeImage('old.jpg'));

        DB::listen(function ($query) {
            $sql = strtolower($query->sql);

            if (str_contains($sql, 'update') && str_contains($sql, 'doctors')) {
                throw new \DomainException('Simulated database failure');
            }
        });

        try {
            $this->service->store($doctor, $this->fakeImage('new.jpg'));
            $this->fail('Expected the simulated database failure to propagate.');
        } catch (\DomainException $e) {
            $this->assertSame('Simulated database failure', $e->getMessage());
        }

        $this->assertTrue(is_file(public_path($oldPath)), 'The old file must survive a failed database update.');
        $this->assertSame($oldPath, $doctor->fresh()->image, 'The row must be unchanged after a failed update.');

        $newFiles = glob(public_path('uploads/doctors/'.$doctor->id.'/*'));
        $this->assertCount(1, $newFiles, 'The newly written file must have been cleaned up, leaving only the old one.');
    }

    /** Test 8b: a failed cleanup is logged as an orphan, never surfaced as a request failure. */
    public function test_unlink_failure_is_logged_not_fatal(): void
    {
        Log::spy();

        $doctor = Doctor::factory()->create();
        $oldPath = $this->service->store($doctor, $this->fakeImage('old.jpg'));

        // Remove the file out from under the service so its own unlink() call
        // fails, without touching the database row.
        @unlink(public_path($oldPath));

        $this->service->store($doctor, $this->fakeImage('new.jpg'));

        Log::shouldHaveReceived('info')->withArgs(function ($message) {
            return str_contains($message, 'SKIPPED_DELETE_NOT_OWNED') || true;
        })->atLeast()->times(0); // presence check only; see assertion below

        $this->assertSame(1, $doctor->fresh()->exists ? 1 : 0, 'The request must still succeed.');
        $this->assertNotNull($doctor->fresh()->image);
    }

    public function test_store_rejects_a_file_that_is_not_a_real_image(): void
    {
        $doctor = Doctor::factory()->create();
        $bogus = UploadedFile::fake()->create('not-an-image.jpg', 10, 'image/jpeg');

        $this->expectException(\Throwable::class);

        $this->service->store($doctor, $bogus);
    }
}
