<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return Patient::query()->orderBy('name');
    }

    public function headings(): array
    {
        return [
            __('Code'),
            __('Name'),
            __('Gender'),
            __('Date of Birth'),
            __('Phone'),
            __('Email'),
            __('Address'),
        ];
    }

    public function map($patient): array
    {
        return [
            $patient->code,
            $patient->name,
            $patient->gender,
            $patient->dob,
            $patient->phone,
            $patient->email,
            $patient->address,
        ];
    }
}
