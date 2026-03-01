<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'branch_id',
        'patient_name',
        'patient_phone',
        'patient_email',
        'patient_address',
        'city',
        'postal_code',
        'booking_type',
        'payment_type',
        'payment_status',
        'total_amount',
        'paid_amount',
        'discount',
        'due_amount',
        'scheduled_date',
        'scheduled_time',
        'status',
        'technician_id',
        'notes',
        'admin_notes',
        'created_by',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'scheduled_time' => 'datetime:H:i:s',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'due_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function report()
    {
        return $this->hasOne(Group::class, 'booking_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services')->withPivot('price')->withTimestamps();
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeHomeVisit($query)
    {
        return $query->where('booking_type', 'home_visit');
    }

    public function scopeBranchVisit($query)
    {
        return $query->where('booking_type', 'branch_visit');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'sample_collected' => 'bg-purple-100 text-purple-800',
            'in_progress' => 'bg-indigo-100 text-indigo-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'no_show' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getBookingTypeBadgeAttribute()
    {
        return $this->booking_type === 'home_visit' 
            ? 'bg-indigo-100 text-indigo-800' 
            : 'bg-emerald-100 text-emerald-800';
    }
}
