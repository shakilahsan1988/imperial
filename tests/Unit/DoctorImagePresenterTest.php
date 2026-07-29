<?php

namespace Tests\Unit;

use App\Models\Doctor;
use App\Support\DoctorImagePresenter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * The avatar fallback rules and the read allowlist.
 *
 * No database is touched: the presenter reads only `image` and `gender`, so an
 * unsaved model is enough.
 */
class DoctorImagePresenterTest extends TestCase
{
    private string $relativePath;

    private string $testAssetsDirectory;

    /**
     * Avatars are pointed at a throwaway, test-only directory rather than the
     * real public/img/avatars/ - that path is reserved for the actual avatar
     * images the operator supplies (decision Q1) and must never receive
     * placeholder test fixtures.
     */
    protected function setUp(): void
    {
        parent::setUp();

        DoctorImagePresenter::flushCache();

        $this->testAssetsDirectory = 'testing-fixtures-'.Str::uuid()->toString();

        // A real file on disk, so "the photo exists" is genuinely true.
        $this->relativePath = 'uploads/doctors/4242/'.Str::uuid()->toString().'.jpg';
        File::ensureDirectoryExists(public_path('uploads/doctors/4242'));
        File::put(public_path($this->relativePath), $this->onePixelJpeg());

        // Shared avatars must exist for the fallback assertions to be
        // meaningful, but written under an isolated test directory.
        foreach (['male', 'female', 'unknown'] as $key) {
            $relative = $this->testAssetsDirectory.'/'.$key.'-avatar.jpg';
            File::ensureDirectoryExists(dirname(public_path($relative)));
            File::put(public_path($relative), $this->onePixelJpeg());

            config(["doctor_sync.avatars.{$key}" => $relative]);
        }
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('uploads/doctors/4242'));
        File::deleteDirectory(public_path($this->testAssetsDirectory));
        DoctorImagePresenter::flushCache();

        parent::tearDown();
    }

    private function doctor(?string $image, ?string $gender): Doctor
    {
        $doctor = new Doctor;
        $doctor->image = $image;
        $doctor->setAttribute('gender', $gender);

        return $doctor;
    }

    /** Test 1: male doctor without a photo gets the male avatar. */
    public function test_male_doctor_without_photo_gets_male_avatar(): void
    {
        $url = DoctorImagePresenter::url($this->doctor(null, 'male'));

        $this->assertStringContainsString((string) config('doctor_sync.avatars.male'), $url);
    }

    /** Test 2: female doctor without a photo gets the female avatar. */
    public function test_female_doctor_without_photo_gets_female_avatar(): void
    {
        $url = DoctorImagePresenter::url($this->doctor(null, 'female'));

        $this->assertStringContainsString((string) config('doctor_sync.avatars.female'), $url);
    }

    /** Test 3: a doctor with a real photo gets that photo, not an avatar. */
    public function test_doctor_with_photo_gets_the_photo(): void
    {
        $url = DoctorImagePresenter::url($this->doctor($this->relativePath, 'male'));

        $this->assertStringContainsString($this->relativePath, $url);
        $this->assertStringNotContainsString((string) config('doctor_sync.avatars.male'), $url);
    }

    /** Test 4: a path that no longer resolves falls back to the gender avatar. */
    public function test_broken_path_falls_back_to_gender_avatar(): void
    {
        $doctor = $this->doctor('uploads/doctors/4242/'.Str::uuid()->toString().'.jpg', 'female');

        $this->assertStringContainsString((string) config('doctor_sync.avatars.female'), DoctorImagePresenter::url($doctor));
        $this->assertFalse(DoctorImagePresenter::hasPersonalImage($doctor));
    }

    /** Test 4a: unknown or missing gender is safe and resolves to the neutral avatar. */
    public function test_unknown_gender_uses_neutral_avatar(): void
    {
        foreach ([null, '', 'unspecified', 'MALE?'] as $gender) {
            $url = DoctorImagePresenter::url($this->doctor(null, $gender === null ? null : (string) $gender));

            $this->assertStringContainsString(
                (string) config('doctor_sync.avatars.unknown'),
                $url,
                'Gender '.var_export($gender, true).' should resolve to the neutral avatar'
            );
        }
    }

    /**
     * Test 4b: hostile paths never reach the filesystem and never render.
     *
     * Each of these must be rejected by safeRelativePath() before any
     * file_exists(), unlink() or asset() call is made with it.
     */
    public function test_malicious_paths_are_rejected_without_touching_the_filesystem(): void
    {
        $hostile = [
            '../../.env',
            'uploads/doctors/../../../.env',
            '/etc/passwd',
            'C:\\Windows\\System32\\drivers\\etc\\hosts',
            'http://evil.example.com/x.jpg',
            'https://evil.example.com/x.jpg',
            '//evil.example.com/x.jpg',
            'uploads/doctors/shell.php',
            'uploads/doctors/x.jpg'."\0".'.php',
            'uploads\\doctors\\x.jpg',
            'storage/app/private/secret.jpg',
            '',
            '   ',
        ];

        foreach ($hostile as $path) {
            $this->assertNull(
                DoctorImagePresenter::safeRelativePath($path),
                'Path should have been rejected: '.var_export($path, true)
            );

            // And the doctor still renders something safe.
            $url = DoctorImagePresenter::url($this->doctor($path, 'male'));
            $this->assertStringContainsString((string) config('doctor_sync.avatars.male'), $url);
        }
    }

    /** Legacy flat paths remain readable, because 14 doctors still use them. */
    public function test_legacy_flat_paths_are_still_readable(): void
    {
        $this->assertSame(
            'uploads/doctors/dr-akil-al-islam.jpg',
            DoctorImagePresenter::safeRelativePath('uploads/doctors/dr-akil-al-islam.jpg')
        );
    }

    /** A one-pixel JPEG, so getimagesize() and the browser both accept it. */
    private function onePixelJpeg(): string
    {
        return base64_decode(
            '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0a'
            .'HBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/wAALCAABAAEBAREA/8QAFAABAAAAAAAA'
            .'AAAAAAAAAAAACf/EABQQAQAAAAAAAAAAAAAAAAAAAAD/2gAIAQEAAD8AKp//2Q=='
        );
    }
}
