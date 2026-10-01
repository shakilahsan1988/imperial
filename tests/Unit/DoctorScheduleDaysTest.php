<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Models\Doctor;
use App\Support\DoctorScheduleDays;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * Guards the day-of-week arithmetic that both the booking datepicker and the
 * booking store method depend on.
 *
 * The datepicker is driven by the JS getDay() scale and the store method by
 * Carbon's dayOfWeek. Those two scales agreeing is an assumption, not a
 * guarantee, so it is asserted directly for all seven days rather than trusted.
 */
class DoctorScheduleDaysTest extends TestCase
{
    use RefreshDatabase;

    /** @var array<int, Branch> branches created by doctorWithSchedule(), in order */
    private array $branches = [];

    /**
     * Create a doctor with one schedule row per given schedule_days string.
     * Each entry gets its own real branch, so the branch ids returned in
     * $this->branches are the ones the assertions use.
     *
     * @param  array<int, ?string>  $daysPerBranch
     */
    private function doctorWithSchedule(array $daysPerBranch): Doctor
    {
        $doctor = Doctor::factory()->create();
        $this->branches = [];

        foreach ($daysPerBranch as $days) {
            $branch = Branch::factory()->create();
            $this->branches[] = $branch;

            $doctor->branchSchedules()->create([
                'branch_id' => $branch->id,
                'consultant' => 'Medicine',
                'schedule_days' => $days,
                'schedule_time' => '10:00 AM - 01:00 PM',
            ]);
        }

        return $doctor->fresh('branchSchedules');
    }

    public function test_branch_days_are_parsed_into_canonical_tokens(): void
    {
        $doctor = $this->doctorWithSchedule(['Sun, Wed']);

        $this->assertSame(['Sun', 'Wed'], DoctorScheduleDays::forBranch($doctor, $this->branches[0]->id));
    }

    public function test_days_are_returned_in_the_clinic_week_order(): void
    {
        $doctor = $this->doctorWithSchedule(['Wed, Sat, Mon']);

        $this->assertSame(['Sat', 'Mon', 'Wed'], DoctorScheduleDays::forBranch($doctor, $this->branches[0]->id));
    }

    /** "Tuesday" is stored verbatim on one live row; the full name must parse. */
    public function test_full_day_names_are_accepted(): void
    {
        $doctor = $this->doctorWithSchedule(['Tuesday']);

        $this->assertSame(['Tue'], DoctorScheduleDays::forBranch($doctor, $this->branches[0]->id));
    }

    public function test_branch_days_do_not_leak_from_another_branch(): void
    {
        $doctor = $this->doctorWithSchedule(['Sun, Wed', 'Mon']);

        $this->assertSame(['Sun', 'Wed'], DoctorScheduleDays::forBranch($doctor, $this->branches[0]->id));
        $this->assertSame(['Mon'], DoctorScheduleDays::forBranch($doctor, $this->branches[1]->id));
    }

    /** A video consult has no branch, so it draws on every branch the doctor works at. */
    public function test_video_days_are_the_union_across_all_branches(): void
    {
        $doctor = $this->doctorWithSchedule(['Sun, Wed', 'Mon, Wed']);

        // Saturday-first clinic week order, not alphabetical.
        $this->assertSame(['Sun', 'Mon', 'Wed'], DoctorScheduleDays::forVideo($doctor));
    }

    public function test_allowed_date_on_a_scheduled_weekday(): void
    {
        $days = ['Sun', 'Wed'];

        $this->assertTrue(DoctorScheduleDays::allowsDate($days, '2026-10-07')); // Wed
        $this->assertFalse(DoctorScheduleDays::allowsDate($days, '2026-10-08')); // Thu
        $this->assertFalse(DoctorScheduleDays::allowsDate($days, '2026-10-06')); // Tue
    }

    /**
     * Fail-closed: a doctor with no usable schedule for a branch is bookable on
     * nothing. One of the live doctor_branch_schedules rows has NULL days, and
     * silently treating it as "any day" would reopen the hole this guards.
     */
    public function test_missing_schedule_fails_closed_for_every_date(): void
    {
        $doctor = $this->doctorWithSchedule([null]);
        $days = DoctorScheduleDays::forBranch($doctor, $this->branches[0]->id);

        $this->assertSame([], $days);
        $this->assertFalse(DoctorScheduleDays::allowsDate($days, '2026-10-07'));
    }

    /** "On Call" is a time label, not a weekday list, so it yields no days. */
    public function test_on_call_label_is_not_treated_as_a_weekday_list(): void
    {
        $doctor = $this->doctorWithSchedule(['On Call']);

        $this->assertSame([], DoctorScheduleDays::forBranch($doctor, $this->branches[0]->id));
    }

    public function test_a_doctor_with_no_schedules_at_all_is_unbookable(): void
    {
        $doctor = Doctor::factory()->create();

        $this->assertSame([], DoctorScheduleDays::forBranch($doctor, Branch::factory()->create()->id));
        $this->assertSame([], DoctorScheduleDays::forVideo($doctor));
    }

    public function test_unknown_or_missing_branch_yields_no_days(): void
    {
        $doctor = $this->doctorWithSchedule(['Sun, Wed']);
        $branchId = $this->branches[0]->id;

        $this->assertSame([], DoctorScheduleDays::forBranch($doctor, $branchId + 9999));
        $this->assertSame([], DoctorScheduleDays::forBranch($doctor, null));
    }

    /**
     * The datepicker disables days by JavaScript getDay() index. If these two
     * scales ever drift, every date in the calendar silently shifts.
     */
    public function test_weekday_numbers_match_carbon_day_of_week(): void
    {
        $expected = [
            'Sun' => 0,
            'Mon' => 1,
            'Tue' => 2,
            'Wed' => 3,
            'Thu' => 4,
            'Fri' => 5,
            'Sat' => 6,
        ];

        foreach ($expected as $token => $number) {
            $date = Carbon::create(2026, 10, 4)->addDays($number); // 2026-10-04 is a Sunday

            $this->assertSame(
                $token,
                $date->format('D'),
                'Fixture drift: the Sunday anchor date is no longer a Sunday.'
            );
            $this->assertSame(
                $number,
                DoctorScheduleDays::WEEKDAY_NUMBERS[$token],
                "{$token} maps to the wrong getDay() index."
            );
        }
    }

    public function test_weekday_numbers_are_deduplicated_and_ordered(): void
    {
        $this->assertSame([0, 3], DoctorScheduleDays::weekdayNumbers(['Sun', 'Wed']));
        $this->assertSame([0, 1, 3], DoctorScheduleDays::weekdayNumbers(['Wed', 'Sun', 'Mon', 'Wed']));
        $this->assertSame([], DoctorScheduleDays::weekdayNumbers([]));
    }

    /** Unparseable input must never turn into a weekday the calendar will offer. */
    public function test_unknown_tokens_are_discarded_rather_than_passed_through(): void
    {
        $this->assertSame([0], DoctorScheduleDays::weekdayNumbers(['Sun', 'notaday']));
        $this->assertSame([], DoctorScheduleDays::weekdayNumbers(['notaday']));
    }
}
