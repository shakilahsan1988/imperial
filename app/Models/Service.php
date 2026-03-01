<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'short_name',
        'category',
        'sub_category',
        'service_category_id',
        'service_sub_category_id',
        'description',
        'preparation',
        'specimen_type',
        'price',
        'home_visit_price',
        'home_visit_available',
        'duration_minutes',
        'image',
        'show_on_frontend',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'home_visit_available' => 'boolean',
        'show_on_frontend' => 'boolean',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'home_visit_price' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(ServiceSubCategory::class, 'service_sub_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeShowOnFrontend($query)
    {
        return $query->where('show_on_frontend', true);
    }

    public function scopeLaboratory($query)
    {
        return $query->where('category', 'laboratory');
    }

    public function scopeImaging($query)
    {
        return $query->where('category', 'imaging');
    }

    public function scopeProcedure($query)
    {
        return $query->where('category', 'procedure');
    }

    public function getCategoryBadgeAttribute()
    {
        $colors = [
            'laboratory' => 'bg-blue-100 text-blue-800',
            'imaging' => 'bg-purple-100 text-purple-800',
            'procedure' => 'bg-green-100 text-green-800',
        ];

        return $colors[$this->category] ?? 'bg-gray-100 text-gray-800';
    }
}
