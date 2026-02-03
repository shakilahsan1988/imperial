<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Visit extends Model
{
    use LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['since'];

    /**
     * Get the patient associated with the visit.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withTrashed();
    }

    /**
     * Interact with the visit's creation time (human-readable).
     */
    protected function since(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->diffForHumans(),
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
            ->useLogName('visit')
            ->setDescriptionForEvent(fn(string $eventName) => "Visit was {$eventName}");
    }
}