<?php

namespace Tests\Feature;

use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipApprovedNamesMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renames_only_verified_membership_masters_and_is_idempotent(): void
    {
        $categories = [
            1 => ['Annual Membership Plans', 'annual-membership-plans-demo'],
            2 => ['Special Health Plans', 'special-health-plans-demo'],
            3 => ['Imperial Anywhere Plan (Video Consultation)', 'imperial-anywhere-plan-video-consultation-demo'],
        ];

        foreach ($categories as $id => [$name, $slug]) {
            MembershipCategory::create([
                'id' => $id,
                'name' => $name,
                'slug' => $slug,
                'description' => $name,
                'status' => true,
                'sort_order' => $id,
            ]);
        }

        $plans = $this->planNames();

        foreach ($plans as $id => [$oldName, , $slug]) {
            MembershipPlan::create([
                'id' => $id,
                'membership_category_id' => $id <= 3 ? 1 : ($id <= 5 ? 2 : 3),
                'page_name' => 'Membership Details',
                'name' => $oldName,
                'slug' => $slug,
                'subtitle' => 'Existing subtitle.',
                'badge_text' => $id === 10 ? 'Senior Care' : null,
                'price' => 1000 + $id,
                'duration' => '12 Months',
                'doctor_visits' => 'Scheduled',
                'service_discount' => '10% Off',
                'description' => 'Existing detailed plan description.',
                'key_features' => 'Feature A'.PHP_EOL.'Feature B',
                'inclusions' => 'Benefit A'.PHP_EOL.'Benefit B',
                'status' => true,
                'show_on_frontend' => true,
                'sort_order' => $id,
            ]);
        }

        $before = MembershipPlan::orderBy('id')->get()->mapWithKeys(function (MembershipPlan $plan) {
            $attributes = $plan->getAttributes();
            unset($attributes['name'], $attributes['badge_text'], $attributes['updated_at']);

            return [$plan->id => $attributes];
        });

        $categoryBefore = MembershipCategory::findOrFail(3)->getAttributes();
        unset($categoryBefore['name'], $categoryBefore['description'], $categoryBefore['updated_at']);

        $migration = require database_path('migrations/2026_08_17_000003_rename_membership_plans_to_approved_imperial_names.php');
        $migration->up();
        $migration->up();

        foreach ($plans as $id => [, $newName, $slug]) {
            $plan = MembershipPlan::findOrFail($id);
            $attributes = $plan->getAttributes();
            unset($attributes['name'], $attributes['badge_text'], $attributes['updated_at']);

            $this->assertSame($newName, $plan->name);
            $this->assertSame($slug, $plan->slug);
            $this->assertSame($before[$id], $attributes);
        }

        $videoCategory = MembershipCategory::findOrFail(3);
        $categoryAttributes = $videoCategory->getAttributes();
        unset($categoryAttributes['name'], $categoryAttributes['description'], $categoryAttributes['updated_at']);

        $this->assertSame('Imperial CareConnect Plans (Video Consultation)', $videoCategory->name);
        $this->assertSame('Imperial CareConnect Plans (Video Consultation)', $videoCategory->description);
        $this->assertSame($categoryBefore, $categoryAttributes);
        $this->assertSame('Senior Support', MembershipPlan::findOrFail(10)->badge_text);
        $this->assertSame(10, MembershipPlan::count());
        $this->assertSame(10, MembershipPlan::distinct()->count('name'));
    }

    /**
     * @return array<int, array{string, string, string}>
     */
    private function planNames(): array
    {
        return [
            1 => ['Imperial Gold Annual Plan', 'Imperial Care Advantage Annual Membership', 'imperial-gold-annual-plan-demo'],
            2 => ['Imperial Silver Annual Plan', 'Imperial Care Essential Annual Membership', 'imperial-silver-annual-plan-demo'],
            3 => ['Imperial Platinum Annual Plan', 'Imperial Care Premier Annual Membership', 'imperial-platinum-annual-plan-demo'],
            4 => ['Prediabetes Plan', 'Imperial Prediabetes Prevention Plan', 'prediabetes-plan-demo'],
            5 => ['Diabetes Plan', 'Imperial Diabetes Care Plan', 'diabetes-plan-demo'],
            6 => ['Imperial Anywhere 12 Months Plan', 'Imperial CareConnect 12-Month Plan', 'imperial-anywhere-12-months-plan-demo'],
            7 => ['Imperial Anywhere 6 Months Plan', 'Imperial CareConnect 6-Month Plan', 'imperial-anywhere-6-months-plan-demo'],
            8 => ['Imperial Anywhere 3 Months Plan', 'Imperial CareConnect 3-Month Plan', 'imperial-anywhere-3-months-plan-demo'],
            9 => ['Imperial Anywhere Family Plus Plan', 'Imperial CareConnect Family Plus Plan', 'imperial-anywhere-family-plus-plan-demo'],
            10 => ['Imperial Anywhere Senior Care Plan', 'Imperial CareConnect Senior Support Plan', 'imperial-anywhere-senior-care-plan-demo'],
        ];
    }
}
