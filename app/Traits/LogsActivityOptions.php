<?php

namespace App\Traits;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;

trait LogsActivityOptions
{
    public function getActivitylogOptions(): LogOptions
    {
        // Automatically gets the model name (e.g., "Doctor" or "ExpenseCategory")
        $logName = Str::snake(class_basename($this));

        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName($logName)
            ->setDescriptionForEvent(fn(string $eventName) => class_basename($this) . " was {$eventName}");
    }
}