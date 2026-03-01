<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupTestResult extends Model
{
    protected $fillable = [
        'group_test_id',
        'service_component_id',
        'result',
        'status'
    ];

    public function groupTest(): BelongsTo
    {
        return $this->belongsTo(GroupTest::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(ServiceComponent::class, 'service_component_id');
    }
}
