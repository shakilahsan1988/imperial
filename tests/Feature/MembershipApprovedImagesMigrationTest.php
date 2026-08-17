<?php

namespace Tests\Feature;

use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipApprovedImagesMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_assigns_the_approved_images_without_changing_plan_data(): void
    {
        $category = MembershipCategory::create([
            'name' => 'Membership Plans',
            'slug' => 'membership-plans',
            'status' => true,
            'sort_order' => 0,
        ]);

        $plans = [
            1 => ['Imperial Care Advantage Annual Membership', 'imperial-care-advantage-annual-membership.png'],
            2 => ['Imperial Care Essential Annual Membership', 'imperial-care-essential-annual-membership.png'],
            3 => ['Imperial Care Premier Annual Membership', 'imperial-care-premier-annual-membership.png'],
            4 => ['Imperial Prediabetes Prevention Plan', 'imperial-prediabetes-prevention-plan.png'],
            5 => ['Imperial Diabetes Care Plan', 'imperial-diabetes-care-plan.png'],
            6 => ['Imperial CareConnect 12-Month Plan', 'imperial-careconnect-12-month-plan.png'],
            7 => ['Imperial CareConnect 6-Month Plan', 'imperial-careconnect-6-month-plan.png'],
            8 => ['Imperial CareConnect 3-Month Plan', 'imperial-careconnect-3-month-plan.png'],
            9 => ['Imperial CareConnect Family Plus Plan', 'imperial-careconnect-family-plus-plan.png'],
            10 => ['Imperial CareConnect Senior Support Plan', 'imperial-careconnect-senior-support-plan.png'],
        ];

        foreach ($plans as $id => [$name]) {
            MembershipPlan::create([
                'id' => $id,
                'membership_category_id' => $category->id,
                'name' => $name,
                'slug' => 'membership-plan-'.$id,
                'price' => 1000 + $id,
                'duration' => '12 Months',
                'description' => 'Existing plan description.',
                'status' => true,
                'show_on_frontend' => true,
                'sort_order' => $id,
            ]);
        }

        $before = MembershipPlan::orderBy('id')->get()->mapWithKeys(function (MembershipPlan $plan) {
            $attributes = $plan->getAttributes();
            unset($attributes['image'], $attributes['updated_at']);

            return [$plan->id => $attributes];
        });

        $migration = require database_path('migrations/2026_08_17_000004_assign_approved_membership_plan_images.php');
        $migration->up();
        $migration->up();

        foreach ($plans as $id => [, $filename]) {
            $plan = MembershipPlan::findOrFail($id);
            $attributes = $plan->getAttributes();
            unset($attributes['image'], $attributes['updated_at']);

            $relativePath = 'uploads/membership_plans/'.$filename;

            $this->assertSame($relativePath, $plan->image);
            $this->assertSame($before[$id], $attributes);
            $this->assertFileExists(public_path($relativePath));
            $this->assertNotFalse(getimagesize(public_path($relativePath)));
        }

        $this->assertSame(10, MembershipPlan::count());
    }
}
