<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupCultureResult extends Model
{
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];
    
    /**
     * Get the antibiotic associated with the culture result.
     */
    public function antibiotic(): BelongsTo
    {
        return $this->belongsTo(Antibiotic::class, 'antibiotic_id', 'id')->withTrashed();
    }
}