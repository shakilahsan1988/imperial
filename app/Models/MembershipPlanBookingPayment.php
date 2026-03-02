<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlanBookingPayment extends Model
{
    protected $fillable = [
        'membership_plan_booking_id',
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
        return $this->belongsTo(MembershipPlanBooking::class, 'membership_plan_booking_id');
    }
}
