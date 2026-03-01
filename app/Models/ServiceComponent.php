<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceComponent extends Model
{
    protected $fillable = [
        'service_id',
        'name',
        'unit',
        'reference_range',
        'sort_order'
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
