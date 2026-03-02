<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembershipDemoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Annual Membership Plans', 'sort_order' => 1],
            ['name' => 'Special Health Plans', 'sort_order' => 2],
            ['name' => 'Amar Jotno Plan (Video Consultation)', 'sort_order' => 3],
        ];

        foreach ($categories as $item) {
            MembershipCategory::updateOrCreate(
                ['name' => $item['name']],
                [
                    'slug' => Str::slug($item['name']) . '-demo',
                    'description' => $item['name'],
                    'sort_order' => $item['sort_order'],
                    'status' => true,
                ]
            );
        }

        $annual = MembershipCategory::where('name', 'Annual Membership Plans')->first();
        $special = MembershipCategory::where('name', 'Special Health Plans')->first();
        $video = MembershipCategory::where('name', 'Amar Jotno Plan (Video Consultation)')->first();

        $plans = [
            [
                'category_id' => $annual?->id,
                'name' => 'Imperial Gold Annual Plan',
                'subtitle' => 'Comprehensive coverage for individuals and families',
                'price' => 12000,
                'old_price' => 15000,
                'discount_text' => '20% OFF',
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited',
                'service_discount' => '15% Off',
                'badge_text' => 'Popular',
                'sort_order' => 1,
            ],
            [
                'category_id' => $annual?->id,
                'name' => 'Imperial Silver Annual Plan',
                'subtitle' => 'Essential healthcare coverage for individuals',
                'price' => 8400,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited',
                'service_discount' => '10% Off',
                'sort_order' => 2,
            ],
            [
                'category_id' => $annual?->id,
                'name' => 'Imperial Platinum Annual Plan',
                'subtitle' => 'Ultimate healthcare protection for families',
                'price' => 21000,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited',
                'service_discount' => '25% Off',
                'badge_text' => 'Premium',
                'sort_order' => 3,
            ],
            [
                'category_id' => $special?->id,
                'name' => 'Prediabetes Plan',
                'subtitle' => 'Early intervention and regular follow-up',
                'price' => 27000,
                'duration' => '12 Months',
                'doctor_visits' => 'Scheduled',
                'service_discount' => '10% Off',
                'sort_order' => 1,
            ],
            [
                'category_id' => $special?->id,
                'name' => 'Diabetes Plan',
                'subtitle' => 'Long-term diabetes management plan',
                'price' => 42000,
                'duration' => '12 Months',
                'doctor_visits' => 'Scheduled',
                'service_discount' => '10% Off',
                'sort_order' => 2,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Amar Jotno 12 Months Plan',
                'subtitle' => 'Unlimited video consultations',
                'price' => 6250,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => 'N/A',
                'badge_text' => 'Best Value',
                'sort_order' => 1,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Amar Jotno 6 Months Plan',
                'subtitle' => 'Unlimited video consultations',
                'price' => 5050,
                'duration' => '6 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => 'N/A',
                'sort_order' => 2,
            ],
        ];

        foreach ($plans as $plan) {
            if (!$plan['category_id']) {
                continue;
            }

            MembershipPlan::updateOrCreate(
                ['name' => $plan['name']],
                [
                    'membership_category_id' => $plan['category_id'],
                    'page_name' => 'Membership Details',
                    'slug' => Str::slug($plan['name']) . '-demo',
                    'subtitle' => $plan['subtitle'],
                    'badge_text' => $plan['badge_text'] ?? null,
                    'price' => $plan['price'],
                    'old_price' => $plan['old_price'] ?? null,
                    'discount_text' => $plan['discount_text'] ?? null,
                    'duration' => $plan['duration'],
                    'doctor_visits' => $plan['doctor_visits'],
                    'service_discount' => $plan['service_discount'],
                    'description' => 'This membership plan is designed for proactive healthcare management and regular specialist support.',
                    'key_features' => "Unlimited or scheduled doctor consultations\nPriority support and appointment booking\nDiscounted diagnostic service access",
                    'inclusions' => "Doctor consultations\nBasic health guidance\nPriority booking support",
                    'exclusions' => "Hospital admission costs\nSurgical procedures\nMedication purchase",
                    'important_notes' => "Plan is non-transferable\nValid for selected duration\nTerms apply",
                    'faq_1_question' => 'How can I book this plan?',
                    'faq_1_answer' => 'Submit the form on this page with your details and our team will contact you.',
                    'faq_2_question' => 'Can I change to another plan later?',
                    'faq_2_answer' => 'Yes, upgrade options are available based on current package policy.',
                    'faq_3_question' => 'Is refund available?',
                    'faq_3_answer' => 'Refund is considered as per membership policy and usage status.',
                    'show_on_frontend' => true,
                    'status' => true,
                    'sort_order' => $plan['sort_order'],
                ]
            );
        }
    }
}
