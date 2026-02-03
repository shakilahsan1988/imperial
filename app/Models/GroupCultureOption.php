<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupCultureOption extends Model
{
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the culture option associated with the group culture option.
     */
    public function culture_option(): BelongsTo
    {
        return $this->belongsTo(CultureOption::class, 'culture_option_id', 'id')->withTrashed();
    }

    /**
     * Get the group culture associated with this option.
     */
    public function group_culture(): BelongsTo
    {
        return $this->belongsTo(GroupCulture::class, 'group_culture_id', 'id');
    }
}