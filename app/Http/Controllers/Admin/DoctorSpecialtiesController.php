<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorSpecialtiesController extends Controller
{
    public function index()
    {
        $specialties = DoctorSpecialty::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.doctor_specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('admin.doctor_specialties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        DoctorSpecialty::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . time(),
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.doctor_specialties.index')->with('success', 'Specialty created successfully.');
    }

    public function edit(DoctorSpecialty $doctor_specialty)
    {
        $specialty = $doctor_specialty;
        return view('admin.doctor_specialties.edit', compact('specialty'));
    }

    public function update(Request $request, DoctorSpecialty $doctor_specialty)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $doctor_specialty->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . $doctor_specialty->id,
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.doctor_specialties.index')->with('success', 'Specialty updated successfully.');
    }

    public function destroy(DoctorSpecialty $doctor_specialty)
    {
        $doctor_specialty->delete();
        return redirect()->route('admin.doctor_specialties.index')->with('success', 'Specialty deleted successfully.');
    }
}
