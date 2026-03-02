<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthPackageBookingPayment extends Model
{
    protected $fillable = [
        'health_package_booking_id',
        'amount',
        'payment_type',
        'paid_at',
        'notes',
        'admin_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(HealthPackageBooking::class, 'health_package_booking_id');
    }
}
