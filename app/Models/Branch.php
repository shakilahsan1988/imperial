<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class Branch extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'branches'; 

    protected $guarded = [];

    /**
     * Activity Log (Spatie v4+)
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() 
            ->logOnlyDirty() 
            ->useLogName('branch')
            ->setDescriptionForEvent(fn(string $eventName) => "Branch was {$eventName}");
    }
}