<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'icon',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function subCategories()
    {
        return $this->hasMany(ServiceSubCategory::class)->orderBy('sort_order')->orderBy('name');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeLaboratory($query)
    {
        return $query->where('type', 'laboratory');
    }

    public function scopeImaging($query)
    {
        return $query->where('type', 'imaging');
    }

    public function scopeProcedure($query)
    {
        return $query->where('type', 'procedure');
    }
}
