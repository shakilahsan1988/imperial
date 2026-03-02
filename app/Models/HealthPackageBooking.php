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
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function package()
    {
        return $this->belongsTo(HealthPackage::class, 'health_package_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
