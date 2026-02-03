<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Get the test details, including trashed records.
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id', 'id')->withTrashed();
    }

    /**
     * Get the results associated with this specific group test.
     */
    public function results(): HasMany
    {
        return $this->hasMany(GroupTestResult::class, 'group_test_id', 'id')->orderBy('id', 'asc');
    }
}