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
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'preferred_start_date' => 'date',
    ];

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
