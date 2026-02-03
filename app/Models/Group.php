<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Group extends Model
{
    use LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'date:d-m-Y H:i',
    ];

    /**
     * Get the tests associated with the group.
     */
    public function tests(): HasMany
    {
        return $this->hasMany(GroupTest::class, 'group_id', 'id');
    }

    /**
     * Get the cultures associated with the group.
     */
    public function cultures(): HasMany
    {
        return $this->hasMany(GroupCulture::class, 'group_id', 'id');
    }

    /**
     * Get the patient associated with the group.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withTrashed();
    }

    /**
     * Get the doctor associated with the group.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withTrashed();
    }

    /**
     * Get the branch associated with the group.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id')->withTrashed();
    }

    /**
     * Get the contract associated with the group.
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id')->withTrashed();
    }

    /**
     * Configure the activity log options for Spatie v4.
     * Replaces the legacy getDescriptionForEvent method.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('group_test')
            ->setDescriptionForEvent(fn(string $eventName) => "Group test was {$eventName}");
    }
}