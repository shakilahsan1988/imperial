<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorConsultationSlot extends Model
{
    protected $fillable = [
        'label',
        'start_time',
        'end_time',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(DoctorConsultationBooking::class, 'doctor_consultation_slot_id');
    }
}
