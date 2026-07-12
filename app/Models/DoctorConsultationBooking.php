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
        'payment_method',
        'payment_status',
        'transaction_id',
        'bank_transaction_id',
        'currency',
        'validation_id',
        'paid_amount',
        'payment_date',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'consultation_fee' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_date' => 'datetime',
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

    public function sslcommerzTransactions()
    {
        return $this->hasMany(SslCommerzTransaction::class, 'consultation_booking_id');
    }
}
