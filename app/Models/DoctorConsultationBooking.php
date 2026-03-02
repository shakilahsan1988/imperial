<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorConsultationBooking extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'doctor_consultation_slot_id',
        'branch_id',
        'patient_name',
        'phone',
        'email',
        'dob',
        'visit_type',
        'appointment_date',
        'notes',
        'consultation_fee',
        'commission_percentage',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'consultation_fee' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function slot()
    {
        return $this->belongsTo(DoctorConsultationSlot::class, 'doctor_consultation_slot_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
