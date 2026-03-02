<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlanBooking;
use App\Models\MembershipPlanBookingPayment;
use Illuminate\Http\Request;

class MembershipPlanBookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = auth()->guard('admin')->user();
            $isSuper = ($u && $u->id == 1);

            if ($isSuper) {
                return $next($request);
            }

            if (!$u || !$u->hasPermission('view_setting')) {
                abort(403, 'You do not have permission to view membership bookings.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $bookings = MembershipPlanBooking::with('plan.category')->latest()->paginate(30);
        $module = 'membership';
        return view('admin.membership_plan_bookings.index', compact('bookings', 'module'));
    }

    public function consultantIndex()
    {
        $bookings = MembershipPlanBooking::with('plan.category')
            ->whereHas('plan', function ($q) {
                $q->where('is_video_consultant', true);
            })
            ->latest()
            ->paginate(30);

        $module = 'video_consultant';
        return view('admin.membership_plan_bookings.index', compact('bookings', 'module'));
    }

    public function show(Request $request, MembershipPlanBooking $membership_plan_booking)
    {
        $booking = $membership_plan_booking->load('plan.category', 'patient', 'payments');
        $module = $request->get('module') === 'video_consultant' ? 'video_consultant' : 'membership';
        return view('admin.membership_plan_bookings.show', compact('booking', 'module'));
    }

    public function update(Request $request, MembershipPlanBooking $membership_plan_booking)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $membership_plan_booking->update($data);
        $module = $request->get('module') === 'video_consultant' ? 'video_consultant' : 'membership';
        $route = $module === 'video_consultant'
            ? 'admin.video_consultant_bookings.index'
            : 'admin.membership_plan_bookings.index';

        return redirect()->route($route)->with('success', 'Membership booking status updated.');
    }

    public function addPayment(Request $request, MembershipPlanBooking $membership_plan_booking)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'nullable|string|max:80',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        MembershipPlanBookingPayment::create([
            'membership_plan_booking_id' => $membership_plan_booking->id,
            'amount' => $data['amount'],
            'payment_type' => $data['payment_type'] ?? null,
            'paid_at' => $data['paid_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
            'admin_id' => optional(auth()->guard('admin')->user())->id,
        ]);

        $newPaid = (float) $membership_plan_booking->paid_amount + (float) $data['amount'];
        $total = (float) $membership_plan_booking->total_amount;
        $newDue = max($total - $newPaid, 0);

        $paymentStatus = 'pending';
        if ($newPaid > 0 && $newDue > 0) {
            $paymentStatus = 'partial';
        } elseif ($newDue <= 0) {
            $paymentStatus = 'paid';
        }

        $membership_plan_booking->update([
            'paid_amount' => $newPaid,
            'due_amount' => $newDue,
            'payment_status' => $paymentStatus,
            'payment_type' => $data['payment_type'] ?? $membership_plan_booking->payment_type,
            'paid_at' => $data['paid_at'] ?? now(),
            'payment_notes' => $data['notes'] ?? $membership_plan_booking->payment_notes,
        ]);

        $module = $request->get('module') === 'video_consultant' ? 'video_consultant' : 'membership';

        return redirect()->route('admin.membership_plan_bookings.show', [
            'membership_plan_booking' => $membership_plan_booking->id,
            'module' => $module,
        ])->with('success', 'Payment added successfully.');
    }

    public function invoice(Request $request, MembershipPlanBooking $membership_plan_booking)
    {
        $booking = $membership_plan_booking->load('plan.category', 'patient', 'payments');
        $module = $request->get('module') === 'video_consultant' ? 'video_consultant' : 'membership';
        return view('admin.membership_plan_bookings.invoice', compact('booking', 'module'));
    }
}
