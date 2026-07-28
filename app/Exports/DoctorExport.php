<?php

namespace App\Exports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DoctorExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    public function query()
    {
        return Doctor::query()->with('specialty')->orderBy('name');
    }

    public function headings(): array
    {
        return [
            __('Code'),
            __('Name'),
            __('Specialty'),
            __('Designation'),
            __('Qualification'),
            __('Phone'),
            __('Email'),
            __('Address'),
            __('Commission'),
            __('Consultation Fee'),
        ];
    }

    public function map($doctor): array
    {
        return [
            $doctor->code,
            $doctor->name,
            optional($doctor->specialty)->name,
            $doctor->designation,
            $doctor->qualification,
            $doctor->phone,
            $doctor->email,
            $doctor->address,
            $doctor->commission,
            $doctor->consultation_fee,
        ];
    }
}
