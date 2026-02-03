<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CultureOption extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the children options for this culture option.
     */
    public function childs(): HasMany
    {
        return $this->hasMany(CultureOption::class, 'parent_id', 'id');
    }

    /**
     * Configure the activity log options for Spatie v4.
     * This replaces the old getDescriptionForEvent method.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('culture_option')
            ->setDescriptionForEvent(fn(string $eventName) => "Culture option was {$eventName}");
    }
}