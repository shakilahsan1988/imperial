<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthPackage extends Model
{
    protected $fillable = [
        'health_package_category_id',
        'page_name',
        'name',
        'slug',
        'subtitle',
        'badge_text',
        'price',
        'old_price',
        'discount_text',
        'image',
        'description',
        'duration',
        'turnaround',
        'fasting',
        'inclusions',
        'preparation_steps',
        'faq_1_question',
        'faq_1_answer',
        'faq_2_question',
        'faq_2_answer',
        'recommended',
        'immediate_availability',
        'show_on_frontend',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'recommended' => 'boolean',
        'immediate_availability' => 'boolean',
        'show_on_frontend' => 'boolean',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(HealthPackageCategory::class, 'health_package_category_id');
    }

    public function bookings()
    {
        return $this->hasMany(HealthPackageBooking::class);
    }
}
