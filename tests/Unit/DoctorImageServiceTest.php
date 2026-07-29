<?php

namespace Tests\Unit;

use App\Models\Doctor;
use App\Services\DoctorImageService;
use App\Support\DoctorImagePresenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Ownership must be proven, never assumed from a filename prefix. Every
 * refusal in this file must leave the file on disk untouched.
 */
class DoctorImageServiceTest extends TestCase
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
     */
    protected function tearDown(): void
    {
        foreach (Doctor::withTrashed()->pluck('id') as $id) {
            File::deleteDirectory(public_path('uploads/doctors/'.$id));
        }

        File::deleteDirectory(public_path('uploads/private-secret'));
        DoctorImagePresenter::flushCache();

        parent::tearDown();
    }

    private function ownedPathFor(Doctor $doctor): string
    {
        $path = 'uploads/doctors/'.$doctor->id.'/'.Str::uuid()->toString().'.jpg';
        File::ensureDirectoryExists(dirname(public_path($path)));
        File::put(public_path($path), 'fake-jpeg-bytes');
        $doctor->forceFill(['image' => $path])->save();

        return $path;
    }

    /**
     * Test 7: deletion can never reach a shared avatar, even if `image` is
     * forced to point at one.
     *
     * Written under an isolated test-only path rather than the real
     * public/img/avatars/ location: that path is reserved for the actual
     * avatar assets the operator supplies (decision Q1) and must never
     * receive a test fixture.
     */
    public function test_remove_never_deletes_a_shared_avatar(): void
    {
        $avatarPath = 'testing-fixtures-'.Str::uuid()->toString().'/male-avatar.jpg';
        File::ensureDirectoryExists(dirname(public_path($avatarPath)));
        File::put(public_path($avatarPath), 'shared-avatar-bytes');

        $doctor = Doctor::factory()->create(['image' => $avatarPath]);

        $this->service->remove($doctor);

        $this->assertTrue(is_file(public_path($avatarPath)), 'The shared avatar must survive a remove() call.');
        $this->assertNull($doctor->fresh()->image);

        File::deleteDirectory(dirname(public_path($avatarPath)));
    }

    /**
     * A doctor's own, correctly id-scoped photo is deletable once it has been
     * superseded - i.e. the doctor row no longer points at it, exactly as
     * store() and remove() arrange before calling assertOwned(). While a path
     * is still the doctor's CURRENT image, assertOwned() correctly refuses it:
     * that is what step 7 (still-referenced check) is for.
     */
    public function test_a_superseded_photo_is_owned_and_deletable(): void
    {
        $doctor = Doctor::factory()->create();
        $path = $this->ownedPathFor($doctor);

        // Still the current image: must NOT be considered deletable yet.
        $this->assertFalse($this->service->assertOwned($doctor, $path));

        // Superseded, as store()/remove() do before deleting the old file.
        $doctor->forceFill(['image' => null])->save();

        $this->assertTrue($this->service->assertOwned($doctor, $path));
    }

    /** Test 7a: legacy flat paths (uploads/doctors/dr-name.jpg) are readable but never deletable. */
    public function test_legacy_flat_path_is_not_owned(): void
    {
        $doctor = Doctor::factory()->create(['image' => 'uploads/doctors/dr-legacy-name.jpg']);

        $this->assertFalse($this->service->assertOwned($doctor, 'uploads/doctors/dr-legacy-name.jpg'));
    }

    /** Test 7a: a path traversal string is never owned. */
    public function test_path_traversal_is_not_owned(): void
    {
        $doctor = Doctor::factory()->create();
        $path = $this->ownedPathFor($doctor);

        $traversal = 'uploads/doctors/'.$doctor->id.'/../../../.env';

        $this->assertFalse($this->service->assertOwned($doctor, $traversal));
        $this->assertTrue(is_file(public_path($path)), 'The real file must be unaffected by a traversal attempt.');
    }

    /** Test 7a: an absolute filesystem path is never owned. */
    public function test_absolute_path_is_not_owned(): void
    {
        $doctor = Doctor::factory()->create();
        $this->ownedPathFor($doctor);

        $absolute = str_replace('\\', '/', public_path('uploads/doctors/'.$doctor->id.'/x.jpg'));

        $this->assertFalse($this->service->assertOwned($doctor, $absolute));
        $this->assertFalse($this->service->assertOwned($doctor, 'C:\\laragon\\www\\imperial\\public\\uploads\\doctors\\1\\x.jpg'));
    }

    /** Test 8/8a-adjacent: a file belonging to a DIFFERENT doctor id is never owned, even by that doctor's own service call. */
    public function test_another_doctors_file_is_not_owned(): void
    {
        $ownerA = Doctor::factory()->create();
        $ownerB = Doctor::factory()->create();
        $pathOwnedByA = $this->ownedPathFor($ownerA);

        $this->assertFalse($this->service->assertOwned($ownerB, $pathOwnedByA));
    }

    /** Test 7a: a symlink pointing outside the doctor's own directory is never owned. */
    public function test_symlink_escaping_the_doctor_directory_is_not_owned(): void
    {
        $doctor = Doctor::factory()->create();
        File::ensureDirectoryExists(public_path('uploads/doctors/'.$doctor->id));

        $secretDir = public_path('uploads/private-secret');
        File::ensureDirectoryExists($secretDir);
        File::put($secretDir.'/secret.jpg', 'top-secret');

        $linkPath = 'uploads/doctors/'.$doctor->id.'/'.Str::uuid()->toString().'.jpg';
        $linked = @symlink($secretDir.'/secret.jpg', public_path($linkPath));

        if (! $linked) {
            $this->markTestSkipped('Symlinks are not permitted in this environment.');
        }

        $this->assertFalse($this->service->assertOwned($doctor, $linkPath));

        // uploads/private-secret is also cleaned up centrally in tearDown(),
        // which runs even when markTestSkipped() short-circuits this method.
    }

    /** An unsaved doctor (no id yet) can never own a file. */
    public function test_unsaved_doctor_owns_nothing(): void
    {
        $doctor = new Doctor(['name' => 'Dr. Unsaved']);

        $this->assertFalse($this->service->assertOwned($doctor, 'uploads/doctors/1/'.Str::uuid()->toString().'.jpg'));
    }

    /** Empty, null-byte and malformed strings are rejected before any filesystem call. */
    public function test_malformed_strings_are_never_owned(): void
    {
        $doctor = Doctor::factory()->create();

        foreach (['', '   ', "uploads/doctors/{$doctor->id}/x.jpg\0.php", 'uploads/doctors/'.$doctor->id.'/not-a-uuid.jpg'] as $candidate) {
            $this->assertFalse($this->service->assertOwned($doctor, $candidate));
        }
    }
}
