<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthPackageBooking extends Model
{
    protected $fillable = [
        'health_package_id',
        'patient_id',
        'patient_name',
        'phone',
        'email',
        'dob',
        'preferred_date',
        'notes',
        'total_amount',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_type',
        'paid_at',
        'payment_notes',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(HealthPackage::class, 'health_package_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function payments()
    {
        return $this->hasMany(HealthPackageBookingPayment::class)->latest();
    }
}
