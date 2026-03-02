<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorConsultationSlot;
use Illuminate\Http\Request;

class DoctorConsultationSlotsController extends Controller
{
    public function index()
    {
        $slots = DoctorConsultationSlot::orderBy('sort_order')->orderBy('start_time')->paginate(30);
        return view('admin.doctor_consultation_slots.index', compact('slots'));
    }

    public function create()
    {
        return view('admin.doctor_consultation_slots.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:120',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        DoctorConsultationSlot::create([
            'label' => $data['label'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.doctor_consultation_slots.index')->with('success', 'Consultation slot created successfully.');
    }

    public function edit(DoctorConsultationSlot $doctor_consultation_slot)
    {
        $slot = $doctor_consultation_slot;
        return view('admin.doctor_consultation_slots.edit', compact('slot'));
    }

    public function update(Request $request, DoctorConsultationSlot $doctor_consultation_slot)
    {
        $data = $request->validate([
            'label' => 'required|string|max:120',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $doctor_consultation_slot->update([
            'label' => $data['label'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.doctor_consultation_slots.index')->with('success', 'Consultation slot updated successfully.');
    }

    public function destroy(DoctorConsultationSlot $doctor_consultation_slot)
    {
        $doctor_consultation_slot->delete();
        return redirect()->route('admin.doctor_consultation_slots.index')->with('success', 'Consultation slot deleted successfully.');
    }
}
