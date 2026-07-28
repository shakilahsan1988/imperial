<?php

namespace App\Imports;

use App\Models\Doctor;
use App\Models\DoctorSpecialty;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DoctorImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
     * Expected heading row: code, name, specialty, designation, qualification,
     * phone, email, address, commission, consultation_fee.
     * "code" is optional — a unique one is generated when it is blank.
     */
    public function model(array $row)
    {
        $code = $row['code'] ?? null;

        if (blank($code) || Doctor::where('code', $code)->exists()) {
            $code = doctor_code();
        }

        return new Doctor([
            'code' => $code,
            'name' => $row['name'],
            'slug' => $this->slug($row['name']),
            'doctor_specialty_id' => $this->specialty_id($row['specialty'] ?? null),
            'designation' => $row['designation'] ?? null,
            'qualification' => $row['qualification'] ?? null,
            'phone' => $row['phone'] ?? null,
            'email' => $row['email'] ?? null,
            'address' => $row['address'] ?? null,
            'commission' => is_numeric($row['commission'] ?? null) ? $row['commission'] : 0,
            'consultation_fee' => is_numeric($row['consultation_fee'] ?? null) ? $row['consultation_fee'] : 0,
            'status' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'email' => 'nullable|email',
        ];
    }

    /**
     * Match an existing specialty by name; unknown names are left unset rather
     * than silently creating new specialties.
     */
    protected function specialty_id($name): ?int
    {
        if (blank($name)) {
            return null;
        }

        return optional(DoctorSpecialty::where('name', trim($name))->first())->id;
    }

    protected function slug($name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $i = 1;

        while (Doctor::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
