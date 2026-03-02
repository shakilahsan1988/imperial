<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'membership_category_id',
        'page_name',
        'name',
        'slug',
        'subtitle',
        'badge_text',
        'price',
        'old_price',
        'discount_text',
        'duration',
        'doctor_visits',
        'service_discount',
        'image',
        'description',
        'key_features',
        'inclusions',
        'exclusions',
        'important_notes',
        'faq_1_question',
        'faq_1_answer',
        'faq_2_question',
        'faq_2_answer',
        'faq_3_question',
        'faq_3_answer',
        'show_on_frontend',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'show_on_frontend' => 'boolean',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(MembershipCategory::class, 'membership_category_id');
    }

    public function bookings()
    {
        return $this->hasMany(MembershipPlanBooking::class);
    }
}
