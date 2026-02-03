<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class Antibiotic extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'antibiotics'; 

    // guarded 
    protected $guarded = [];

    public $timestamps = false;
    
    // getDescriptionForEvent
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() 
            ->useLogName('antibiotic')
            ->setDescriptionForEvent(fn(string $eventName) => "Antibiotic was {$eventName}");
    }
}