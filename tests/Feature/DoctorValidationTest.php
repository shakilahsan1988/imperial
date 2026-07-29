<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\DoctorDepartment;
use App\Models\DoctorSpecialty;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test 19c and the correction to plan point #1: contacts are nullable, but
 * a real value must still be unique. Exercised through the actual admin route
 * and DoctorRequest, not by calling the rule in isolation - this is also what
 * proves the historic bug ("every doctor shares one email, so no doctor can be
 * saved") is fixed.
 */
class DoctorValidationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private int $specialtyId;

    private int $departmentId;

    protected function setUp(): void
    {
        parent::setUp();

        // id=1 is the hard-coded super-admin in User::can()/hasPermission().
        $this->admin = User::factory()->create(['id' => 1]);

        $this->specialtyId = DoctorSpecialty::create([
            'name' => 'Medicine', 'slug' => 'medicine', 'status' => true, 'sort_order' => 0,
        ])->id;
        $this->departmentId = DoctorDepartment::create([
            'name' => 'Medicine', 'slug' => 'medicine', 'status' => true, 'sort_order' => 0,
        ])->id;
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Dr. Test Doctor',
            'doctor_specialty_id' => $this->specialtyId,
            'doctor_department_id' => $this->departmentId,
            'address' => 'Imperial Private Health Care BD Limited',
            'commission' => 0,
            'consultation_fee' => 500,
        ], $overrides);
    }

    /** Multiple doctors may have a null email and a null phone. */
    public function test_two_doctors_can_both_have_no_email_or_phone(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['name' => 'Dr. First']))
            ->assertSessionDoesntHaveErrors(['email', 'phone']);

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['name' => 'Dr. Second']))
            ->assertSessionDoesntHaveErrors(['email', 'phone']);

        $this->assertSame(2, Doctor::whereNull('email')->whereNull('phone')->count());
    }

    /** A real email must still be unique across doctors. */
    public function test_duplicate_real_email_is_rejected(): void
    {
        Doctor::factory()->create(['email' => 'unique@example.com']);

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['email' => 'unique@example.com']))
            ->assertSessionHasErrors(['email']);
    }

    /** A real phone must still be unique across doctors. */
    public function test_duplicate_real_phone_is_rejected(): void
    {
        Doctor::factory()->create(['phone' => '01711111111']);

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['phone' => '01711111111']))
            ->assertSessionHasErrors(['phone']);
    }

    /**
     * The historic bug: every doctor previously shared doctor@iphcbd.com, so
     * `required|unique` on email/phone made every edit fail. Saving a doctor
     * unchanged must now succeed.
     */
    public function test_an_existing_doctor_can_be_saved_without_changing_contact_fields(): void
    {
        $doctor = Doctor::factory()->create(['email' => null, 'phone' => null]);

        $response = $this->actingAs($this->admin, 'admin')->put(
            route('admin.doctors.update', $doctor->id),
            $this->payload(['name' => $doctor->name])
        );

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(route('admin.doctors.index'));
    }

    /** A doctor updating to keep its OWN existing email must not be rejected as a duplicate of itself. */
    public function test_a_doctor_can_keep_its_own_email_on_update(): void
    {
        $doctor = Doctor::factory()->create(['email' => 'keep-mine@example.com']);

        $this->actingAs($this->admin, 'admin')->put(
            route('admin.doctors.update', $doctor->id),
            $this->payload(['name' => $doctor->name, 'email' => 'keep-mine@example.com'])
        )->assertSessionDoesntHaveErrors(['email']);
    }

    /** A blank string in the form must be treated as no value, not as an empty-string collision. */
    public function test_blank_email_is_normalized_to_null_and_does_not_collide(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['name' => 'Dr. Blank One', 'email' => '   ']))
            ->assertSessionDoesntHaveErrors(['email']);

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['name' => 'Dr. Blank Two', 'email' => '']))
            ->assertSessionDoesntHaveErrors(['email']);
    }

    /** Email is case-normalized so "A@B.com" and "a@b.com" are recognised as the same address. */
    public function test_email_uniqueness_is_case_insensitive(): void
    {
        Doctor::factory()->create(['email' => 'someone@example.com']);

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.doctors.store'), $this->payload(['email' => 'SOMEONE@EXAMPLE.COM']))
            ->assertSessionHasErrors(['email']);
    }
}
