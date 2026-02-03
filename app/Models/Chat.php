<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['since'];
    
    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime:H:i',
    ];

    /**
     * Get the user that sent the message.
     */
    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    /**
     * Get the user that received the message.
     */
    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    /**
     * Interact with the chat's "since" time.
     * Updated to Laravel 12 fluent attribute syntax.
     */
    protected function since(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->diffForHumans(),
        );
    }
}