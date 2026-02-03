<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupTestResult extends Model
{
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the test component associated with the result.
     */
    public function component(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id', 'id')->withTrashed();
    }
}