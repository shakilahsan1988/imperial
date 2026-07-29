<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorConsultationBooking;
use App\Models\DoctorConsultationSlot;
use App\Support\DoctorBookingGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * The query that decides whether a schedule is safe to change.
 *
 * Covers plan tests 16 (booked appointments preserved), 16a (timezone-correct
 * date boundary, not a raw CURDATE()) and 16b (a booking with no branch_id
 * blocks every branch for that doctor).
 */
class DoctorBookingGuardTest extends TestCase
{
    use RefreshDatabase;

    private Doctor $doctor;

    private Branch $branchA;

    private Branch $branchB;

    private int $slotId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->doctor = Doctor::factory()->create();
        $this->branchA = Branch::factory()->create();
        $this->branchB = Branch::factory()->create();

        $this->slotId = DoctorConsultationSlot::create([
            'label' => '09:00 AM - 09:30 AM',
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
            'status' => true,
            'sort_order' => 1,
        ])->id;
    }

    private function makeBooking(array $overrides = []): DoctorConsultationBooking
    {
        return DoctorConsultationBooking::create(array_merge([
            'doctor_id' => $this->doctor->id,
            'doctor_consultation_slot_id' => $this->slotId,
            'branch_id' => $this->branchA->id,
            'patient_name' => 'Test Patient',
            'phone' => '01700000000',
            'email' => 'patient@example.com',
            'visit_type' => 'in_hub',
            'appointment_date' => Carbon::now(config('app.timezone'))->addDay()->toDateString(),
            'consultation_fee' => 500,
            'commission_percentage' => 0,
            'status' => 'confirmed',
        ], $overrides));
    }

    /** Test 16: a future, non-cancelled booking blocks the schedule. */
    public function test_future_booking_blocks_the_branch(): void
    {
        $this->makeBooking();

        $this->assertSame(
            1,
            DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchA->id)
        );
    }

    /** A cancelled or completed booking does not block. */
    public function test_cancelled_and_completed_bookings_do_not_block(): void
    {
        $this->makeBooking(['status' => 'cancelled']);
        $this->makeBooking(['status' => 'completed']);

        $this->assertSame(
            0,
            DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchA->id)
        );
    }

    /** A past appointment date does not block a future schedule change. */
    public function test_past_booking_does_not_block(): void
    {
        $this->makeBooking([
            'appointment_date' => Carbon::now(config('app.timezone'))->subDay()->toDateString(),
        ]);

        $this->assertSame(
            0,
            DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchA->id)
        );
    }

    /** A booking at a different branch does not block this branch. */
    public function test_booking_at_a_different_branch_does_not_block(): void
    {
        $this->makeBooking(['branch_id' => $this->branchB->id]);

        $this->assertSame(
            0,
            DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchA->id)
        );
    }

    /**
     * Test 16b: a booking with no branch_id is not tied to a branch, so it
     * blocks every branch schedule for that doctor rather than none.
     */
    public function test_booking_with_no_branch_blocks_every_branch(): void
    {
        $this->makeBooking(['branch_id' => null]);

        $this->assertSame(1, DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchA->id));
        $this->assertSame(1, DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchB->id));
    }

    /**
     * Test 16a: "today" is decided by config('app.timezone'), not the
     * database session's local time.
     *
     * config('app.timezone') is UTC. A booking dated "today" in a timezone
     * ahead of UTC (matching the server's SYSTEM timezone observed on this
     * database) is still today - or even yesterday - in UTC. The guard must
     * use the app timezone consistently rather than a raw SQL CURDATE(),
     * which would evaluate against the database session's timezone instead.
     */
    public function test_date_boundary_uses_app_timezone_not_database_local_time(): void
    {
        $todayInAppTimezone = Carbon::now(config('app.timezone'))->toDateString();

        $this->makeBooking(['appointment_date' => $todayInAppTimezone]);

        $this->assertSame(
            1,
            DoctorBookingGuard::blockingBookingCount($this->doctor->id, $this->branchA->id),
            "A booking dated 'today' in config('app.timezone') must block, regardless of the database server's local timezone."
        );
    }
}
