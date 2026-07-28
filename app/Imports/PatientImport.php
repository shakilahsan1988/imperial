<?php

namespace App\Imports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PatientImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
     * Expected heading row: code, name, gender, date_of_birth, phone, email, address.
     * "code" is optional — a unique one is generated when it is blank.
     */
    public function model(array $row)
    {
        $code = $row['code'] ?? null;

        if (blank($code) || Patient::where('code', $code)->exists()) {
            $code = patient_code();
        }

        return new Patient([
            'code' => $code,
            'name' => $row['name'],
            'gender' => $this->gender($row['gender'] ?? null),
            'dob' => $this->date($row['date_of_birth'] ?? $row['dob'] ?? null),
            'phone' => $row['phone'] ?? null,
            'email' => $row['email'] ?? null,
            'address' => $row['address'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'email' => 'nullable|email',
        ];
    }

    protected function gender($value): string
    {
        $value = strtolower(trim((string) $value));

        return in_array($value, ['male', 'female']) ? $value : 'male';
    }

    protected function date($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        // Excel serial dates come through as numbers.
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
