<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\DoctorConsultationBooking;
use App\Models\DoctorConsultationSlot;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * The appointment date must land on a day the doctor actually works at the
 * selected branch.
 *
 * The datepicker prevents an honest patient from picking a wrong day, but that
 * is only a convenience - these tests drive the POST directly, which is exactly
 * what a client bypassing the form would do. Every rejection here is therefore
 * enforced by the server alone.
 */
class DoctorBookingScheduleTest extends TestCase
{
    use RefreshDatabase;

    private Doctor $doctor;

    private Branch $branchA;

    private Branch $branchB;

    private int $slotId;

    /** Weekday tokens for the fixed "Sunday and Wednesday" branch A. */
    private const BRANCH_A_DAYS = 'Sun, Wed';

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        // The booking page renders formated_price(), which reads the currency
        // out of the "info" setting. Without it the view throws and the page
        // tests below would assert against a 500 error page instead.
        Setting::create([
            'key' => 'info',
            'value' => json_encode(['currency' => 'BDT', 'email' => 'info@example.com']),
        ]);
        Cache::forget('currency');

        $this->doctor = Doctor::factory()->create([
            'video_consultation_available' => true,
        ]);

        $this->branchA = Branch::factory()->create();
        $this->branchB = Branch::factory()->create();

        $this->doctor->branchSchedules()->create([
            'branch_id' => $this->branchA->id,
            'consultant' => 'Medicine',
            'schedule_days' => self::BRANCH_A_DAYS,
            'schedule_time' => '10:00 AM - 01:00 PM',
        ]);

        // Branch B works a completely different week so a leak between branches
        // shows up as a failure rather than a coincidence.
        $this->doctor->branchSchedules()->create([
            'branch_id' => $this->branchB->id,
            'consultant' => 'Medicine',
            'schedule_days' => 'Mon, Thu',
            'schedule_time' => '04:00 PM - 06:00 PM',
        ]);

        $this->slotId = DoctorConsultationSlot::create([
            'label' => '09:00 AM - 09:30 AM',
            'start_time' => '09:00:00',
            'end_time' => '09:30:00',
            'status' => true,
            'sort_order' => 1,
        ])->id;
    }

    /**
     * The next future occurrence of a weekday, as Y-m-d.
     *
     * Derived rather than hardcoded so the test cannot drift into the past and
     * trip the separate after_or_equal:today rule instead of the rule under test.
     */
    private function nextWeekday(string $threeLetterDay): string
    {
        $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $today = Carbon::now(config('app.timezone'))->startOfDay();

        for ($offset = 0; $offset < 8; $offset++) {
            $candidate = $today->copy()->addDays($offset);

            if ($candidate->format('D') === $threeLetterDay) {
                return $candidate->toDateString();
            }
        }

        $this->fail("Could not resolve a future {$threeLetterDay}.");
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'patient_name' => 'Test Patient',
            'phone' => '01700000000',
            'email' => 'patient@example.com',
            'visit_type' => 'in_hub',
            'branch_id' => $this->branchA->id,
            'appointment_date' => $this->nextWeekday('Wed'),
            'doctor_consultation_slot_id' => $this->slotId,
        ], $overrides);
    }

    public function test_booking_is_accepted_on_a_scheduled_weekday(): void
    {
        $response = $this->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload()
        );

        $booking = DoctorConsultationBooking::first();

        $this->assertNotNull($booking, 'A scheduled weekday must be accepted.');
        $this->assertSame($this->branchA->id, $booking->branch_id);
        $this->assertSame('in_hub', $booking->visit_type);
        $response->assertRedirect(route('doctor-booking.confirm', $booking->id));
    }

    /**
     * The bypass case: a posted date that no branch schedule covers must be
     * rejected, and no booking row may be left behind.
     */
    public function test_booking_is_rejected_on_an_unscheduled_weekday(): void
    {
        $response = $this->from(route('book-doctor', $this->doctor->slug))->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload(['appointment_date' => $this->nextWeekday('Fri')])
        );

        $response->assertSessionHasErrors('appointment_date');
        $this->assertDatabaseCount('doctor_consultation_bookings', 0);
    }

    public function test_rejection_message_names_the_branch(): void
    {
        $this->from(route('book-doctor', $this->doctor->slug))->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload(['appointment_date' => $this->nextWeekday('Fri')])
        );

        $this->assertSame(
            'The selected date is not available for this doctor at this branch.',
            session('errors')->first('appointment_date')
        );
    }

    /** A day that only branch B works must not be bookable through branch A. */
    public function test_branch_a_rejects_a_day_that_only_branch_b_works(): void
    {
        $response = $this->from(route('book-doctor', $this->doctor->slug))->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload(['appointment_date' => $this->nextWeekday('Thu')])
        );

        $response->assertSessionHasErrors('appointment_date');
        $this->assertDatabaseCount('doctor_consultation_bookings', 0);
    }

    public function test_branch_b_accepts_its_own_weekdays(): void
    {
        $this->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload([
                'branch_id' => $this->branchB->id,
                'appointment_date' => $this->nextWeekday('Thu'),
            ])
        );

        $this->assertDatabaseCount('doctor_consultation_bookings', 1);
    }

    /**
     * A video consult has no branch, so it draws on the union of every branch the
     * doctor works at. Thursday is reachable only through branch B's schedule and
     * must still be bookable.
     */
    public function test_video_consult_accepts_a_day_from_any_branch(): void
    {
        $this->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload([
                'visit_type' => 'video',
                'branch_id' => null,
                'appointment_date' => $this->nextWeekday('Thu'),
                'appointment_time' => '10:00 AM - 01:00 PM',
            ])
        );

        $booking = DoctorConsultationBooking::first();

        $this->assertNotNull($booking);
        $this->assertSame('video', $booking->visit_type);
    }

    public function test_video_consult_rejects_a_day_the_doctor_never_works(): void
    {
        $response = $this->from(route('book-doctor', $this->doctor->slug))->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload([
                'visit_type' => 'video',
                'branch_id' => null,
                'appointment_date' => $this->nextWeekday('Sat'),
                'appointment_time' => '10:00 AM - 01:00 PM',
            ])
        );

        $response->assertSessionHasErrors('appointment_date');
        $this->assertDatabaseCount('doctor_consultation_bookings', 0);
    }

    /**
     * Fail-closed: with no recorded days for the branch, nothing is bookable.
     * Defaulting to "any day" here would let an unscheduled doctor take bookings.
     */
    public function test_branch_with_no_recorded_days_is_unbookable(): void
    {
        $this->doctor->branchSchedules()->update([
            'schedule_days' => null,
        ]);

        $response = $this->from(route('book-doctor', $this->doctor->slug))->post(
            route('book-doctor.submit', ['doctor' => $this->doctor->slug]),
            $this->payload(['appointment_date' => $this->nextWeekday('Wed')])
        );

        $response->assertSessionHasErrors('appointment_date');
        $this->assertDatabaseCount('doctor_consultation_bookings', 0);
    }

    /**
     * The booking page must hand the browser the weekday sets it needs, otherwise
     * the calendar cannot disable anything.
     *
     * Branch A works Sun + Wed -> getDay() [0, 3]; branch B works Mon + Thu -> [1, 4].
     * Asserted as one JSON fragment built with the same flags Blade's @json uses
     * (15 = JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT), so the
     * expected string matches the rendered script byte for byte.
     */
    public function test_booking_page_exposes_allowed_weekdays_per_branch(): void
    {
        $response = $this->get(route('book-doctor', $this->doctor->slug));

        $response->assertOk();

        $response->assertSee(json_encode([
            $this->branchA->id => [0, 3],
            $this->branchB->id => [1, 4],
        ], 15), false);
    }

    /**
     * Available days are colour coded green and the corner pill names the
     * enabled weekdays. Both are driven by the inline script, so assert the
     * hooks survive a render.
     */
    public function test_booking_page_ships_the_green_days_and_availability_pill(): void
    {
        $response = $this->get(route('book-doctor', $this->doctor->slug));

        $response->assertOk();

        // Green treatment for bookable days.
        $response->assertSee('day-available', false);
        $response->assertSee('.flatpickr-day.day-available', false);
        // The pill, its text node, and the renderer that fills both.
        $response->assertSee('id="available-days-pill"', false);
        $response->assertSee('id="available-days-text"', false);
        $response->assertSee('renderAvailabilityPill', false);
    }
}
