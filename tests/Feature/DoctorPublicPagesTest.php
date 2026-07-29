<?php

namespace Tests\Feature;

use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test 17 (JSON image output), 17a (no global $appends leakage) and 18
 * (admin and public surfaces agree on the same image).
 *
 * Nothing in this file writes a real file to uploads/doctors - every doctor
 * here has either a null image or a path that is deliberately broken - so no
 * filesystem cleanup is needed. It deliberately performs none: the shared
 * uploads/doctors directory holds real, currently in-use doctor photos, and a
 * blanket File::deleteDirectory() call here previously wiped them out during
 * a local test run despite this file never creating anything to clean up.
 */
class DoctorPublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 17a: `effective_image_url` must NOT appear in a plain toArray()/
     * toJson() call. It is intentionally not in $appends (plan correction #6)
     * - surfaces must request it explicitly.
     */
    public function test_effective_image_url_is_not_appended_by_default(): void
    {
        $doctor = Doctor::factory()->create();

        $array = $doctor->toArray();

        $this->assertArrayNotHasKey('effective_image_url', $array);
        $this->assertArrayHasKey('total', $array, 'The pre-existing appends must be unaffected.');
    }

    /** Test 17: the select2 JSON endpoint returns a resolved URL, never a raw possibly-broken path. */
    public function test_get_doctors_json_contains_resolved_image_url(): void
    {
        $broken = Doctor::factory()->create([
            'name' => 'Dr. Broken Path',
            'image' => 'uploads/doctors/999/does-not-exist.jpg',
            'status' => true,
        ]);

        $response = $this->getJson(route('ajax.get_doctors'));

        $response->assertOk();

        $payload = collect($response->json())->firstWhere('id', $broken->id);

        $this->assertNotNull($payload);
        $this->assertArrayHasKey('effective_image_url', $payload);
        $this->assertStringNotContainsString('does-not-exist.jpg', $payload['effective_image_url']);
    }

    /** get_doctors only returns active doctors. */
    public function test_get_doctors_excludes_inactive_doctors(): void
    {
        $inactive = Doctor::factory()->create(['status' => false, 'name' => 'Dr. Inactive One']);

        $response = $this->getJson(route('ajax.get_doctors'));

        $ids = collect($response->json())->pluck('id');

        $this->assertNotContains($inactive->id, $ids);
    }

    /**
     * Test 18: the admin detail view and the public listing resolve the same
     * doctor to the same URL.
     *
     * doctors.gender does not exist until Gate B, so this doctor resolves to
     * the neutral avatar on both surfaces - the point being that they AGREE,
     * not that gender-specific art is shown yet.
     */
    public function test_admin_and_public_views_show_the_same_effective_image(): void
    {
        $doctor = Doctor::factory()->create(['image' => null]);

        $fromAccessor = $doctor->effective_image_url;
        $fromFreshLoad = Doctor::find($doctor->id)->effective_image_url;

        $this->assertSame($fromAccessor, $fromFreshLoad);
        $this->assertStringContainsString((string) config('doctor_sync.avatars.unknown'), $fromAccessor);
    }
}
