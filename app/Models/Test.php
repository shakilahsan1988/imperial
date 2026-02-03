<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Test extends Model
{
    use SoftDeletes, LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the components (child tests) for this test.
     */
    public function components(): HasMany
    {
        return $this->hasMany(Test::class, 'parent_id', 'id')->orderBy('id', 'asc');
    }

    /**
     * Get the sub-analyses associated with this test.
     */
    public function sub_analyses(): HasMany
    {
        return $this->hasMany(Test::class, 'parent_id', 'id')->where('separated', 1);
    }

    /**
     * Get the predefined options for this test.
     */
    public function options(): HasMany
    {
        return $this->hasMany(TestOption::class, 'test_id', 'id');
    }

    /**
     * Configure the activity log options for Spatie v4.
     * This replaces the legacy getDescriptionForEvent method.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('test')
            ->setDescriptionForEvent(fn(string $eventName) => "Test was {$eventName}");
    }
}