<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPackageBooking;
use Illuminate\Http\Request;

class HealthPackageBookingsController extends Controller
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
                abort(403, 'You do not have permission to view health package bookings.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $bookings = HealthPackageBooking::with('package')->latest()->paginate(30);
        return view('admin.health_package_bookings.index', compact('bookings'));
    }

    public function show(HealthPackageBooking $health_package_booking)
    {
        $booking = $health_package_booking->load('package.category');
        return view('admin.health_package_bookings.show', compact('booking'));
    }

    public function update(Request $request, HealthPackageBooking $health_package_booking)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $health_package_booking->update($data);

        return redirect()->route('admin.health_package_bookings.index')->with('success', 'Booking status updated.');
    }
}
