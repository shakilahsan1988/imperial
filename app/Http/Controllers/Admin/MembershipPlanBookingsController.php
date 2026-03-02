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
        $booking = $membership_plan_booking->load('plan.category', 'patient');
        $module = $request->get('module') === 'video_consultant' ? 'video_consultant' : 'membership';
        return view('admin.membership_plan_bookings.show', compact('booking', 'module'));
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
