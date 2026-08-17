<?php

namespace Database\Seeders;

use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipDemoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Annual Membership Plans', 'slug' => 'annual-membership-plans-demo', 'sort_order' => 1],
            ['name' => 'Special Health Plans', 'slug' => 'special-health-plans-demo', 'sort_order' => 2],
            ['name' => 'Imperial CareConnect Plans (Video Consultation)', 'slug' => 'imperial-anywhere-plan-video-consultation-demo', 'sort_order' => 3],
        ];

        foreach ($categories as $item) {
            MembershipCategory::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'description' => $item['name'],
                    'sort_order' => $item['sort_order'],
                    'status' => true,
                ]
            );
        }

        $annual = MembershipCategory::where('slug', 'annual-membership-plans-demo')->first();
        $special = MembershipCategory::where('slug', 'special-health-plans-demo')->first();
        $video = MembershipCategory::where('slug', 'imperial-anywhere-plan-video-consultation-demo')->first();

        $plans = [
            [
                'category_id' => $annual?->id,
                'name' => 'Imperial Care Advantage Annual Membership',
                'slug' => 'imperial-gold-annual-plan-demo',
                'image' => 'uploads/membership_plans/imperial-care-advantage-annual-membership.png',
                'subtitle' => 'Comprehensive coverage for individuals and families',
                'price' => 12000,
                'old_price' => 15000,
                'discount_text' => '20% OFF',
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited',
                'service_discount' => '15% Off',
                'badge_text' => 'Popular',
                'sort_order' => 1,
                'is_video_consultant' => false,
            ],
            [
                'category_id' => $annual?->id,
                'name' => 'Imperial Care Essential Annual Membership',
                'slug' => 'imperial-silver-annual-plan-demo',
                'image' => 'uploads/membership_plans/imperial-care-essential-annual-membership.png',
                'subtitle' => 'Essential healthcare coverage for individuals',
                'price' => 8400,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited',
                'service_discount' => '10% Off',
                'sort_order' => 2,
                'is_video_consultant' => false,
            ],
            [
                'category_id' => $annual?->id,
                'name' => 'Imperial Care Premier Annual Membership',
                'slug' => 'imperial-platinum-annual-plan-demo',
                'image' => 'uploads/membership_plans/imperial-care-premier-annual-membership.png',
                'subtitle' => 'Ultimate healthcare protection for families',
                'price' => 21000,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited',
                'service_discount' => '25% Off',
                'badge_text' => 'Premium',
                'sort_order' => 3,
                'is_video_consultant' => false,
            ],
            [
                'category_id' => $special?->id,
                'name' => 'Imperial Prediabetes Prevention Plan',
                'slug' => 'prediabetes-plan-demo',
                'image' => 'uploads/membership_plans/imperial-prediabetes-prevention-plan.png',
                'subtitle' => 'Early intervention and regular follow-up',
                'price' => 27000,
                'duration' => '12 Months',
                'doctor_visits' => 'Scheduled',
                'service_discount' => '10% Off',
                'sort_order' => 1,
                'is_video_consultant' => false,
            ],
            [
                'category_id' => $special?->id,
                'name' => 'Imperial Diabetes Care Plan',
                'slug' => 'diabetes-plan-demo',
                'image' => 'uploads/membership_plans/imperial-diabetes-care-plan.png',
                'subtitle' => 'Long-term diabetes management plan',
                'price' => 42000,
                'duration' => '12 Months',
                'doctor_visits' => 'Scheduled',
                'service_discount' => '10% Off',
                'sort_order' => 2,
                'is_video_consultant' => false,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Imperial CareConnect 12-Month Plan',
                'slug' => 'imperial-anywhere-12-months-plan-demo',
                'image' => 'uploads/membership_plans/imperial-careconnect-12-month-plan.png',
                'subtitle' => 'Unlimited video consultations',
                'price' => 6250,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => 'N/A',
                'badge_text' => 'Best Value',
                'sort_order' => 1,
                'is_video_consultant' => true,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Imperial CareConnect 6-Month Plan',
                'slug' => 'imperial-anywhere-6-months-plan-demo',
                'image' => 'uploads/membership_plans/imperial-careconnect-6-month-plan.png',
                'subtitle' => 'Unlimited video consultations',
                'price' => 5050,
                'duration' => '6 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => 'N/A',
                'sort_order' => 2,
                'is_video_consultant' => true,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Imperial CareConnect 3-Month Plan',
                'slug' => 'imperial-anywhere-3-months-plan-demo',
                'image' => 'uploads/membership_plans/imperial-careconnect-3-month-plan.png',
                'subtitle' => 'Unlimited video consultations',
                'price' => 3850,
                'duration' => '3 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => 'N/A',
                'sort_order' => 3,
                'is_video_consultant' => true,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Imperial CareConnect Family Plus Plan',
                'slug' => 'imperial-anywhere-family-plus-plan-demo',
                'image' => 'uploads/membership_plans/imperial-careconnect-family-plus-plan.png',
                'subtitle' => 'Family focused video consultation package',
                'price' => 8450,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => '5% Off Diagnostics',
                'badge_text' => 'Family',
                'sort_order' => 4,
                'is_video_consultant' => true,
            ],
            [
                'category_id' => $video?->id,
                'name' => 'Imperial CareConnect Senior Support Plan',
                'slug' => 'imperial-anywhere-senior-care-plan-demo',
                'image' => 'uploads/membership_plans/imperial-careconnect-senior-support-plan.png',
                'subtitle' => 'Video consultations tailored for seniors',
                'price' => 7250,
                'duration' => '12 Months',
                'doctor_visits' => 'Unlimited Video',
                'service_discount' => '10% Off Follow-up Tests',
                'badge_text' => 'Senior Support',
                'sort_order' => 5,
                'is_video_consultant' => true,
            ],
        ];

        foreach ($plans as $plan) {
            if (! $plan['category_id']) {
                continue;
            }

            MembershipPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                [
                    'membership_category_id' => $plan['category_id'],
                    'page_name' => 'Membership Details',
                    'name' => $plan['name'],
                    'subtitle' => $plan['subtitle'],
                    'image' => $plan['image'],
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
                    'is_video_consultant' => $plan['is_video_consultant'] ?? false,
                    'status' => true,
                    'sort_order' => $plan['sort_order'],
                ]
            );
        }
    }
}
