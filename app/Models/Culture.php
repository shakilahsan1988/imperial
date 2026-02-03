<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Culture extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Configure the activity log options for Spatie v4.
     * This replaces the old getDescriptionForEvent method.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('culture')
            ->setDescriptionForEvent(fn(string $eventName) => "Culture was {$eventName}");
    }
}