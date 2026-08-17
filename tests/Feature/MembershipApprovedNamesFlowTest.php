<?php

namespace Tests\Feature;

use App\Models\MembershipCategory;
use App\Models\MembershipPlan;
use App\Models\MembershipPlanBooking;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipApprovedNamesFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @var array<int, string> */
    private array $names = [
        1 => 'Imperial Care Advantage Annual Membership',
        2 => 'Imperial Care Essential Annual Membership',
        3 => 'Imperial Care Premier Annual Membership',
        4 => 'Imperial Prediabetes Prevention Plan',
        5 => 'Imperial Diabetes Care Plan',
        6 => 'Imperial CareConnect 12-Month Plan',
        7 => 'Imperial CareConnect 6-Month Plan',
        8 => 'Imperial CareConnect 3-Month Plan',
        9 => 'Imperial CareConnect Family Plus Plan',
        10 => 'Imperial CareConnect Senior Support Plan',
    ];

    /** @var array<int, string> */
    private array $slugs = [
        1 => 'imperial-gold-annual-plan-demo',
        2 => 'imperial-silver-annual-plan-demo',
        3 => 'imperial-platinum-annual-plan-demo',
        4 => 'prediabetes-plan-demo',
        5 => 'diabetes-plan-demo',
        6 => 'imperial-anywhere-12-months-plan-demo',
        7 => 'imperial-anywhere-6-months-plan-demo',
        8 => 'imperial-anywhere-3-months-plan-demo',
        9 => 'imperial-anywhere-family-plus-plan-demo',
        10 => 'imperial-anywhere-senior-care-plan-demo',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Setting::create([
            'key' => 'info',
            'value' => json_encode([
                'name' => 'Imperial Private Health Care BD',
                'currency' => 'BDT',
            ]),
        ]);

        $categories = [
            1 => 'Annual Membership Plans',
            2 => 'Special Health Plans',
            3 => 'Imperial CareConnect Plans (Video Consultation)',
        ];

        foreach ($categories as $id => $name) {
            MembershipCategory::create([
                'id' => $id,
                'name' => $name,
                'slug' => 'membership-category-'.$id,
                'description' => $name,
                'status' => true,
                'sort_order' => $id,
            ]);
        }

        foreach ($this->names as $id => $name) {
            MembershipPlan::create([
                'id' => $id,
                'membership_category_id' => $id <= 3 ? 1 : ($id <= 5 ? 2 : 3),
                'page_name' => 'Membership Details',
                'name' => $name,
                'slug' => $this->slugs[$id],
                'subtitle' => 'Existing membership subtitle.',
                'badge_text' => $id === 10 ? 'Senior Support' : null,
                'price' => 1000 + $id,
                'duration' => '12 Months',
                'doctor_visits' => 'Scheduled',
                'service_discount' => '10% Off',
                'description' => 'Existing detailed membership description.',
                'key_features' => 'Feature A'.PHP_EOL.'Feature B',
                'inclusions' => 'Benefit A'.PHP_EOL.'Benefit B',
                'exclusions' => 'Exclusion A',
                'important_notes' => 'Existing membership terms.',
                'show_on_frontend' => true,
                'is_video_consultant' => $id >= 6,
                'status' => true,
                'sort_order' => $id,
            ]);
        }
    }

    public function test_public_admin_and_sitemap_surfaces_use_approved_names_with_preserved_slugs(): void
    {
        $listing = $this->get(route('membership'))->assertOk();

        foreach ($this->names as $name) {
            $listing->assertSee($name);
        }

        foreach ($this->slugs as $id => $slug) {
            $this->assertStringContainsString($slug, $listing->getContent());
            $this->get(route('membership-details', ['id' => $slug]))
                ->assertOk()
                ->assertSee($this->names[$id]);
        }

        $videoConsultation = $this->get(route('video-consultation'))->assertOk();
        foreach (array_slice($this->names, 5, null, true) as $name) {
            $videoConsultation->assertSee($name);
        }
        $videoConsultation->assertSee('Why choose Imperial CareConnect?');

        $admin = User::factory()->create(['id' => 1]);
        $adminIndex = $this->actingAs($admin, 'admin')
            ->get(route('admin.membership_plans.index'))
            ->assertOk();

        foreach ($this->names as $name) {
            $adminIndex->assertSee($name);
        }

        $sitemap = $this->get(route('seo.sitemap'))->assertOk();
        foreach ($this->slugs as $slug) {
            $sitemap->assertSee($slug);
        }
    }

    public function test_booking_and_dynamic_invoice_keep_the_same_plan_id_price_and_slug(): void
    {
        $plan = MembershipPlan::findOrFail(1);

        $this->post(route('membership-booking.submit', ['slug' => $plan->slug]), [
            'patient_name' => 'Membership Flow Test',
            'phone' => '01700000000',
            'email' => 'membership-flow@example.test',
            'dob' => '1990-01-01',
            'preferred_start_date' => now()->addDay()->toDateString(),
            'notes' => 'Automated membership booking.',
        ])->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $booking = MembershipPlanBooking::sole();

        $this->assertSame($plan->id, $booking->membership_plan_id);
        $this->assertSame($plan->price, $booking->total_amount);
        $this->assertSame($plan->price, $booking->due_amount);
        $this->assertSame($this->slugs[1], $booking->plan->slug);
        $this->assertSame($this->names[1], $booking->plan->name);

        $admin = User::factory()->create(['id' => 1]);
        $this->actingAs($admin, 'admin')
            ->get(route('admin.membership_plan_bookings.invoice', $booking->id))
            ->assertOk()
            ->assertSee($this->names[1]);
    }
}
