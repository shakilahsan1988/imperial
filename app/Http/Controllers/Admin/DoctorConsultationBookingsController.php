<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorConsultationBooking;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorConsultationBookingsController extends Controller
{
    public function index()
    {
        $bookings = DoctorConsultationBooking::with(['doctor.department', 'slot', 'branch', 'patient'])
            ->latest()
            ->paginate(30);

        return view('admin.doctor_consultation_bookings.index', compact('bookings'));
    }

    public function show(DoctorConsultationBooking $doctor_consultation_booking)
    {
        $booking = $doctor_consultation_booking->load(['doctor.specialty', 'doctor.department', 'slot', 'branch', 'patient']);
        return view('admin.doctor_consultation_bookings.show', compact('booking'));
    }

    public function update(Request $request, DoctorConsultationBooking $doctor_consultation_booking)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        if (!$doctor_consultation_booking->patient_id && in_array($data['status'], ['confirmed', 'completed'])) {
            $email = strtolower(trim((string) $doctor_consultation_booking->email));
            $patient = Patient::where('email', $email)->first();

            if (!$patient) {
                $patient = Patient::create([
                    'code' => patient_code(),
                    'name' => $doctor_consultation_booking->patient_name,
                    'gender' => 'male',
                    'dob' => $doctor_consultation_booking->dob ?: now()->subYears(20)->format('Y-m-d'),
                    'email' => $email,
                    'phone' => $doctor_consultation_booking->phone,
                ]);
            } else {
                $patient->update([
                    'name' => $doctor_consultation_booking->patient_name,
                    'phone' => $doctor_consultation_booking->phone,
                    'dob' => $doctor_consultation_booking->dob ?: $patient->dob,
                ]);
            }

            $doctor_consultation_booking->patient_id = $patient->id;
        }

        $doctor_consultation_booking->status = $data['status'];
        $doctor_consultation_booking->save();

        return redirect()->route('admin.doctor_consultation_bookings.index')->with('success', 'Consultation booking updated successfully.');
    }
}
