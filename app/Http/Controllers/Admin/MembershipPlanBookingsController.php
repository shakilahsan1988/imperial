<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlanBooking;
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
        return view('admin.membership_plan_bookings.index', compact('bookings'));
    }

    public function show(MembershipPlanBooking $membership_plan_booking)
    {
        $booking = $membership_plan_booking->load('plan.category', 'patient');
        return view('admin.membership_plan_bookings.show', compact('booking'));
    }

    public function update(Request $request, MembershipPlanBooking $membership_plan_booking)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $membership_plan_booking->update($data);
        return redirect()->route('admin.membership_plan_bookings.index')->with('success', 'Membership booking status updated.');
    }
}
