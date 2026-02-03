<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait HasActivityLog
{
    use LogsActivity;

    /**
     * Common Activity Log Options for all Models
     *
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()              
            ->logOnlyDirty()        
            ->useLogName($this->getTable()) 
            ->dontSubmitEmptyLogs(); 
    }
}