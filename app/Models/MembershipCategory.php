<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function plans()
    {
        return $this->hasMany(MembershipPlan::class)->orderBy('sort_order')->orderBy('name');
    }
}
