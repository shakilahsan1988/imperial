<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GroupCulture extends Model
{
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * Get the culture associated with the group culture.
     */
    public function culture(): BelongsTo
    {
        return $this->belongsTo(Culture::class, 'culture_id', 'id')->withTrashed();
    }

    /**
     * Get all antibiotics results for this culture.
     */
    public function antibiotics(): HasMany
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->orderBy('id', 'asc');
    }

    /**
     * Get high sensitivity antibiotics results.
     */
    public function high_antibiotics(): HasMany
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity', 'High');
    }

    /**
     * Get moderate sensitivity antibiotics results.
     */
    public function moderate_antibiotics(): HasMany
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity', 'Moderate');
    }

    /**
     * Get resident (resistant) antibiotics results.
     */
    public function resident_antibiotics(): HasMany
    {
        return $this->hasMany(GroupCultureResult::class, 'group_culture_id', 'id')->where('sensitivity', 'Resident');
    }

    /**
     * Get the options associated with the group culture.
     */
    public function culture_options(): HasMany
    {
        return $this->hasMany(GroupCultureOption::class, 'group_culture_id', 'id');
    }
}