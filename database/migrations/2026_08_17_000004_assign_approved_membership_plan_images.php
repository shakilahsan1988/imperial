<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * @var array<int, array{name: string, image: string}>
     */
    private array $plans = [
        1 => [
            'name' => 'Imperial Care Advantage Annual Membership',
            'image' => 'uploads/membership_plans/imperial-care-advantage-annual-membership.png',
        ],
        2 => [
            'name' => 'Imperial Care Essential Annual Membership',
            'image' => 'uploads/membership_plans/imperial-care-essential-annual-membership.png',
        ],
        3 => [
            'name' => 'Imperial Care Premier Annual Membership',
            'image' => 'uploads/membership_plans/imperial-care-premier-annual-membership.png',
        ],
        4 => [
            'name' => 'Imperial Prediabetes Prevention Plan',
            'image' => 'uploads/membership_plans/imperial-prediabetes-prevention-plan.png',
        ],
        5 => [
            'name' => 'Imperial Diabetes Care Plan',
            'image' => 'uploads/membership_plans/imperial-diabetes-care-plan.png',
        ],
        6 => [
            'name' => 'Imperial CareConnect 12-Month Plan',
            'image' => 'uploads/membership_plans/imperial-careconnect-12-month-plan.png',
        ],
        7 => [
            'name' => 'Imperial CareConnect 6-Month Plan',
            'image' => 'uploads/membership_plans/imperial-careconnect-6-month-plan.png',
        ],
        8 => [
            'name' => 'Imperial CareConnect 3-Month Plan',
            'image' => 'uploads/membership_plans/imperial-careconnect-3-month-plan.png',
        ],
        9 => [
            'name' => 'Imperial CareConnect Family Plus Plan',
            'image' => 'uploads/membership_plans/imperial-careconnect-family-plus-plan.png',
        ],
        10 => [
            'name' => 'Imperial CareConnect Senior Support Plan',
            'image' => 'uploads/membership_plans/imperial-careconnect-senior-support-plan.png',
        ],
    ];

    public function up(): void
    {
        DB::transaction(function () {
            foreach ($this->plans as $expectedId => $plan) {
                $targetId = $this->verifiedPlanId($expectedId, $plan['name']);

                if ($targetId === null) {
                    continue;
                }

                DB::table('membership_plans')
                    ->where('id', $targetId)
                    ->where('name', $plan['name'])
                    ->where(function ($query) use ($plan) {
                        $query->whereNull('image')->orWhere('image', '<>', $plan['image']);
                    })
                    ->update([
                        'image' => $plan['image'],
                        'updated_at' => now(),
                    ]);
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            foreach ($this->plans as $expectedId => $plan) {
                $targetId = $this->verifiedPlanId($expectedId, $plan['name']);

                if ($targetId === null) {
                    continue;
                }

                DB::table('membership_plans')
                    ->where('id', $targetId)
                    ->where('name', $plan['name'])
                    ->where('image', $plan['image'])
                    ->update([
                        'image' => null,
                        'updated_at' => now(),
                    ]);
            }
        });
    }

    private function verifiedPlanId(int $expectedId, string $name): ?int
    {
        $expectedPlan = DB::table('membership_plans')
            ->where('id', $expectedId)
            ->where('name', $name)
            ->first(['id']);

        if ($expectedPlan) {
            return (int) $expectedPlan->id;
        }

        $matches = DB::table('membership_plans')
            ->where('name', $name)
            ->get(['id']);

        if ($matches->count() > 1) {
            throw new RuntimeException("Multiple membership plans match the verified name: {$name}");
        }

        return $matches->isEmpty() ? null : (int) $matches->first()->id;
    }
};
