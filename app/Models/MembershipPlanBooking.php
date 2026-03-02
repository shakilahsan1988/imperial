<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlanBooking extends Model
{
    protected $fillable = [
        'membership_plan_id',
        'patient_id',
        'patient_name',
        'phone',
        'email',
        'dob',
        'preferred_start_date',
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
        'dob' => 'date',
        'preferred_start_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function payments()
    {
        return $this->hasMany(MembershipPlanBookingPayment::class)->latest();
    }
}
