<?php

namespace App\Support;

use App\Models\DoctorConsultationBooking;
use Illuminate\Support\Carbon;

/**
 * Decides whether a doctor's schedule at a branch is safe to change.
 *
 * Single source of truth for the booking-protection query, used by both the
 * admin schedule form (DoctorsController) and the read-only audit
 * (DoctorAuditService). Duplicating this query in two places would let them
 * drift; a fix to one guard without the other would silently reopen the gap
 * it closed.
 *
 * The date boundary is computed in PHP against config('app.timezone') rather
 * than left to a raw SQL CURDATE(), because config('app.timezone') is UTC
 * while the database session runs on the server's local time - a SQL-side
 * comparison is off by a day for part of every day.
 */
final class DoctorBookingGuard
{
    /**
     * Count bookings that make it unsafe to remove or overwrite a doctor's
     * schedule at a branch.
     *
     * A booking with no branch_id is not tied to a branch, so it is treated as
     * blocking every schedule for that doctor rather than none - the
     * conservative direction when the data does not say which branch a
     * booking belongs to.
     */
    public static function blockingBookingCount(int $doctorId, int $branchId): int
    {
        $today = Carbon::now(config('app.timezone'))->toDateString();
        $nonBlocking = (array) config('doctor_sync.bookings.non_blocking_statuses', ['cancelled', 'completed']);

        return DoctorConsultationBooking::query()
            ->where('doctor_id', $doctorId)
            ->where(fn ($q) => $q->where('branch_id', $branchId)->orWhereNull('branch_id'))
            ->whereDate('appointment_date', '>=', $today)
            ->whereNotIn('status', $nonBlocking)
            ->count();
    }
}
