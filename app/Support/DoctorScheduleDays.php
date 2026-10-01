<?php

namespace App\Support;

use App\Models\Doctor;
use Illuminate\Support\Carbon;

/**
 * Resolves which weekdays a doctor is actually available for a booking.
 *
 * Schedule data enters this application as free text ("Sun, Wed") typed by hand
 * into the admin doctor form. This class is the one place that turns that text
 * into the weekday set that BOTH the booking datepicker and the booking
 * validation depend on, so the calendar can never offer a day the store method
 * would then reject.
 *
 * ScheduleNormalizer does the text parsing; this class owns the availability
 * decision layered on top of it - which rows apply to a branch, how a video
 * consultation (which has no branch) draws its days, and the fail-closed rule
 * when a schedule is missing.
 *
 * SCOPE: this governs DATES only. It deliberately never produces a bookable
 * time slot - those remain the global doctor_consultation_slots table, exactly
 * as ScheduleNormalizer's own docblock requires.
 */
final class DoctorScheduleDays
{
    /**
     * Canonical weekday token -> JavaScript Date.getDay() index (0 = Sunday).
     *
     * Carbon's dayOfWeek and JS getDay() are both 0=Sunday..6=Saturday, so this
     * one map serves the backend and the datepicker without any translation.
     *
     * @var array<string, int>
     */
    public const WEEKDAY_NUMBERS = [
        'Sun' => 0,
        'Mon' => 1,
        'Tue' => 2,
        'Wed' => 3,
        'Thu' => 4,
        'Fri' => 5,
        'Sat' => 6,
    ];

    /**
     * Weekdays this doctor works at one branch.
     *
     * A unique index on (doctor_id, branch_id) means there is exactly one
     * schedule row per branch in practice. This still iterates every matching
     * row rather than reading the first, so it stays correct if that index is
     * ever relaxed or a row is loaded from an unindexed source.
     *
     * @return array<int, string> canonical tokens in clinic week order
     */
    public static function forBranch(Doctor $doctor, ?int $branchId): array
    {
        if ($branchId === null) {
            return [];
        }

        $branchId = (int) $branchId;

        return self::order(self::collectDays(
            $doctor->branchSchedules->filter(
                fn ($schedule) => (int) $schedule->branch_id === $branchId
            )
        ));
    }

    /**
     * Weekdays this doctor works for a video consultation.
     *
     * A video consult has no branch - the doctor is online - so the allowed days
     * are the UNION across every branch they work at, never an intersection.
     * This keeps video bookings at least as permissive as the doctor's in-hub
     * schedule without ever offering a day they do not work.
     *
     * @return array<int, string>
     */
    public static function forVideo(Doctor $doctor): array
    {
        return self::order(self::collectDays($doctor->branchSchedules));
    }

    /**
     * Whether a requested appointment date falls on a working day.
     *
     * FAILS CLOSED: a doctor with no usable schedule for the chosen branch can be
     * booked on nothing. Defaulting to "any day" there would quietly reopen the
     * exact hole this check exists to close. One of the live
     * doctor_branch_schedules rows has NULL days, and that doctor is
     * intentionally unbookable at that branch until staff fill the schedule in.
     *
     * @param  array<int, string>  $allowedDays  canonical weekday tokens
     */
    public static function allowsDate(array $allowedDays, string $date): bool
    {
        $days = self::order($allowedDays);

        if ($days === []) {
            return false;
        }

        // appointment_date is a date-only column already validated by 'date'.
        // Parsing a Y-m-d string yields local midnight, so dayOfWeek is correct
        // regardless of app.timezone being UTC while MySQL runs on server local
        // time - the same off-by-a-day trap DoctorBookingGuard documents.
        $weekday = array_search((int) Carbon::parse($date)->dayOfWeek, self::WEEKDAY_NUMBERS, true);

        return $weekday !== false && in_array($weekday, $days, true);
    }

    /**
     * The JS getDay() indices for a set of canonical tokens, for the datepicker.
     *
     * @param  array<int, string>  $days
     * @return array<int, int>
     */
    public static function weekdayNumbers(array $days): array
    {
        $numbers = [];

        foreach (self::order($days) as $day) {
            $numbers[] = self::WEEKDAY_NUMBERS[$day];
        }

        return array_values(array_unique($numbers));
    }

    /**
     * @param  \Illuminate\Support\Collection<int, \App\Models\DoctorBranchSchedule>  $schedules
     * @return array<int, string>
     */
    private static function collectDays($schedules): array
    {
        $days = [];

        foreach ($schedules as $schedule) {
            $parsed = ScheduleNormalizer::days($schedule->schedule_days);

            // A schedule that does not parse - NULL, empty, or a label such as
            // "On Call" typed into the days box - contributes NO days. Paired
            // with the fail-closed rule this makes such a branch unbookable
            // rather than silently bookable on arbitrary days.
            if (! $parsed['valid']) {
                continue;
            }

            foreach ($parsed['days'] as $day) {
                $days[] = $day;
            }
        }

        return $days;
    }

    /**
     * De-duplicate and sort into the clinic's Saturday-first week order.
     *
     * @param  array<int, string>  $days
     * @return array<int, string>
     */
    private static function order(array $days): array
    {
        $unique = array_values(array_filter(
            array_unique($days),
            fn ($day) => isset(self::WEEKDAY_NUMBERS[$day])
        ));

        usort($unique, static fn ($a, $b) => array_search($a, ScheduleNormalizer::WEEK, true)
            <=> array_search($b, ScheduleNormalizer::WEEK, true));

        return $unique;
    }
}
