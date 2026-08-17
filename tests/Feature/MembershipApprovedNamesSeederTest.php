<?php

namespace Tests\Feature;

use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use Database\Seeders\MembershipDemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipApprovedNamesSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_membership_seed_data_is_approved_and_idempotent(): void
    {
        $this->seed(MembershipDemoSeeder::class);
        $firstIdsBySlug = MembershipPlan::pluck('id', 'slug');

        $this->seed(MembershipDemoSeeder::class);

        $approvedNames = [
            'Imperial Care Essential Annual Membership',
            'Imperial Care Advantage Annual Membership',
            'Imperial Care Premier Annual Membership',
            'Imperial Prediabetes Prevention Plan',
            'Imperial Diabetes Care Plan',
            'Imperial CareConnect 3-Month Plan',
            'Imperial CareConnect 6-Month Plan',
            'Imperial CareConnect 12-Month Plan',
            'Imperial CareConnect Family Plus Plan',
            'Imperial CareConnect Senior Support Plan',
        ];

        $this->assertSame(10, MembershipPlan::count());
        $this->assertSame(10, MembershipPlan::distinct()->count('name'));
        $this->assertSame(10, MembershipPlan::whereIn('name', $approvedNames)->count());
        $this->assertSame($firstIdsBySlug->all(), MembershipPlan::pluck('id', 'slug')->all());
        $this->assertSame(3, MembershipCategory::count());
        $this->assertDatabaseHas('membership_categories', [
            'slug' => 'imperial-anywhere-plan-video-consultation-demo',
            'name' => 'Imperial CareConnect Plans (Video Consultation)',
        ]);
        $this->assertDatabaseHas('membership_plans', [
            'slug' => 'imperial-anywhere-senior-care-plan-demo',
            'name' => 'Imperial CareConnect Senior Support Plan',
            'badge_text' => 'Senior Support',
            'image' => 'uploads/membership_plans/imperial-careconnect-senior-support-plan.png',
        ]);
    }
}
