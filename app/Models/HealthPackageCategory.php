<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthPackageCategory extends Model
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

    public function packages()
    {
        return $this->hasMany(HealthPackage::class)->orderBy('sort_order')->orderBy('name');
    }
}
