<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPackageBooking;
use App\Models\HealthPackageBookingPayment;
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
        $booking = $health_package_booking->load('package.category', 'payments');
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

    public function addPayment(Request $request, HealthPackageBooking $health_package_booking)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'nullable|string|max:80',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);

        HealthPackageBookingPayment::create([
            'health_package_booking_id' => $health_package_booking->id,
            'amount' => $data['amount'],
            'payment_type' => $data['payment_type'] ?? null,
            'paid_at' => $data['paid_at'] ?? now(),
            'notes' => $data['notes'] ?? null,
            'admin_id' => optional(auth()->guard('admin')->user())->id,
        ]);

        $newPaid = (float) $health_package_booking->paid_amount + (float) $data['amount'];
        $total = (float) $health_package_booking->total_amount;
        $newDue = max($total - $newPaid, 0);

        $paymentStatus = 'pending';
        if ($newPaid > 0 && $newDue > 0) {
            $paymentStatus = 'partial';
        } elseif ($newDue <= 0) {
            $paymentStatus = 'paid';
        }

        $health_package_booking->update([
            'paid_amount' => $newPaid,
            'due_amount' => $newDue,
            'payment_status' => $paymentStatus,
            'payment_type' => $data['payment_type'] ?? $health_package_booking->payment_type,
            'paid_at' => $data['paid_at'] ?? now(),
            'payment_notes' => $data['notes'] ?? $health_package_booking->payment_notes,
        ]);

        return redirect()->route('admin.health_package_bookings.show', $health_package_booking->id)->with('success', 'Payment added successfully.');
    }

    public function invoice(HealthPackageBooking $health_package_booking)
    {
        $booking = $health_package_booking->load('package.category', 'payments', 'patient');
        return view('admin.health_package_bookings.invoice', compact('booking'));
    }
}
