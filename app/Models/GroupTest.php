<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupTest extends Model
{
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the group that owns the test.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    /**
     * Get the service associated with this entry.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id')->withTrashed();
    }

    /**
     * Get the sub-results for this test (if it's a profile).
     */
    public function results(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GroupTestResult::class, 'group_test_id', 'id');
    }
}
