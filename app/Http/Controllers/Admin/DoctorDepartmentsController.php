<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorDepartmentsController extends Controller
{
    public function index()
    {
        $departments = DoctorDepartment::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.doctor_departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.doctor_departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        DoctorDepartment::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . time(),
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.doctor_departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(DoctorDepartment $doctor_department)
    {
        $department = $doctor_department;
        return view('admin.doctor_departments.edit', compact('department'));
    }

    public function update(Request $request, DoctorDepartment $doctor_department)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $doctor_department->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . $doctor_department->id,
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.doctor_departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(DoctorDepartment $doctor_department)
    {
        $doctor_department->delete();
        return redirect()->route('admin.doctor_departments.index')->with('success', 'Department deleted successfully.');
    }
}
