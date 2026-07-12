<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SslCommerzTransaction extends Model
{
    use LogsActivity;

    protected $table = 'sslcommerz_transactions';

    protected $fillable = [
        'consultation_booking_id',
        'transaction_id',
        'bank_transaction_id',
        'amount',
        'currency',
        'status',
        'validation_id',
        'ipn_response',
        'card_type',
        'card_no',
        'bank_gateway',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'ipn_response' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('sslcommerz_transaction')
            ->setDescriptionForEvent(fn (string $eventName) => "SSLCommerz transaction was {$eventName}");
    }

    public function consultationBooking()
    {
        return $this->belongsTo(DoctorConsultationBooking::class, 'consultation_booking_id');
    }
}
