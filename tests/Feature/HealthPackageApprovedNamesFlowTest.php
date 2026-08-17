<?php

namespace Tests\Feature;

use App\Models\HealthPackage;
use App\Models\HealthPackageBooking;
use App\Models\HealthPackageCategory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthPackageApprovedNamesFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @var array<int, string> */
    private array $names = [
        1 => 'Imperial Women’s Wellness Check – Under 40',
        2 => 'Imperial Women’s Wellness Check – 40 to 65',
        3 => 'Imperial Women’s Senior Wellness Check – 65+',
        4 => 'Imperial Women’s Heart Health Check',
        5 => 'Imperial Men’s Wellness Check – Under 40',
        6 => 'Imperial Men’s Wellness Check – 40 to 65',
        7 => 'Imperial Men’s Senior Wellness Check – 65+',
        8 => 'Imperial Men’s Executive Health Check',
    ];

    /** @var array<int, string> */
    private array $oldSlugs = [
        1 => 'her-health-under-40-1772465158-1',
        2 => 'her-health-40-65-1772465158-2',
        3 => 'her-health-above-65-1772465362-1',
        4 => 'womens-cardiac-check-1772465362-2',
        5 => 'his-health-under-40-1772465158-3',
        6 => 'his-health-40-65-1772465158-4',
        7 => 'his-health-above-65-1772465362-3',
        8 => 'mens-executive-check-1772465362-4',
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

        $category = HealthPackageCategory::create([
            'name' => 'Wellness',
            'slug' => 'wellness',
            'status' => true,
            'sort_order' => 0,
        ]);

        foreach ($this->names as $id => $name) {
            HealthPackage::create([
                'id' => $id,
                'health_package_category_id' => $category->id,
                'page_name' => 'Package Details',
                'name' => $name,
                'slug' => $this->oldSlugs[$id],
                'subtitle' => 'Existing package subtitle.',
                'price' => 1000 + $id,
                'description' => 'Existing detailed package description.',
                'inclusions' => 'Test A'.PHP_EOL.'Test B',
                'status' => true,
                'show_on_frontend' => true,
                'sort_order' => $id,
            ]);
        }
    }

    public function test_listing_details_admin_and_sitemap_use_approved_names_with_preserved_slugs(): void
    {
        $listing = $this->get(route('health-check'))->assertOk();

        foreach ($this->names as $name) {
            $listing->assertSee($name);
        }

        foreach ($this->oldSlugs as $slug) {
            $this->assertStringContainsString($slug, $listing->getContent());
        }

        $details = $this->get(route('package-details', $this->oldSlugs[1]))
            ->assertOk()
            ->assertSee($this->names[1])
            ->assertSee('class="block h-auto w-full rounded-2xl"', false);

        $details->assertDontSee('aspect-[4/5]', false);

        $admin = User::factory()->create(['id' => 1]);
        $adminIndex = $this->actingAs($admin, 'admin')
            ->get(route('admin.health_packages.index'))
            ->assertOk();

        foreach ($this->names as $name) {
            $adminIndex->assertSee($name);
        }

        $sitemap = $this->get(route('seo.sitemap'))->assertOk();
        foreach ($this->oldSlugs as $slug) {
            $sitemap->assertSee($slug);
        }
    }

    public function test_booking_uses_the_same_package_id_price_and_preserved_slug(): void
    {
        $package = HealthPackage::findOrFail(1);

        $this->post(route('package-booking.submit', $package->slug), [
            'patient_name' => 'Package Flow Test',
            'phone' => '01700000000',
            'email' => 'package-flow@example.test',
            'dob' => '1990-01-01',
            'preferred_date' => now()->addDay()->toDateString(),
            'notes' => 'Automated test booking.',
        ])->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $booking = HealthPackageBooking::sole();

        $this->assertSame($package->id, $booking->health_package_id);
        $this->assertSame($package->price, $booking->total_amount);
        $this->assertSame($package->price, $booking->due_amount);
        $this->assertSame($this->oldSlugs[1], $booking->package->slug);
        $this->assertSame($this->names[1], $booking->package->name);
    }
}
