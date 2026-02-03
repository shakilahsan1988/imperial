<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Doctor extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['total', 'paid', 'due'];

    /**
     * Get the groups associated with the doctor.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'doctor_id', 'id');
    }

    /**
     * Get the expenses associated with the doctor.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'doctor_id', 'id');
    }

    /**
     * Interact with the doctor's total commission.
     */
    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->groups->sum('doctor_commission'),
        );
    }

    /**
     * Interact with the doctor's paid amount.
     */
    protected function paid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->expenses->sum('amount'),
        );
    }

    /**
     * Interact with the doctor's due amount.
     */
    protected function due(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total - $this->paid,
        );
    }

    /**
     * Configure the activity log options for Spatie v4.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('doctor')
            ->setDescriptionForEvent(fn(string $eventName) => "Doctor was {$eventName}");
    }
}