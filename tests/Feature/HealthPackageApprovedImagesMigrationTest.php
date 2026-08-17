<?php

namespace Tests\Feature;

use App\Models\HealthPackage;
use App\Models\HealthPackageCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthPackageApprovedImagesMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_assigns_the_approved_images_without_changing_package_data(): void
    {
        $category = HealthPackageCategory::create([
            'name' => 'Wellness',
            'slug' => 'wellness',
            'status' => true,
            'sort_order' => 0,
        ]);

        $packages = [
            1 => ['Imperial Women’s Wellness Check – Under 40', 'imperial-womens-wellness-under-40.png'],
            2 => ['Imperial Women’s Wellness Check – 40 to 65', 'imperial-womens-wellness-40-to-65.png'],
            3 => ['Imperial Men’s Wellness Check – Under 40', 'imperial-mens-wellness-under-40.png'],
            4 => ['Imperial Men’s Wellness Check – 40 to 65', 'imperial-mens-wellness-40-to-65.png'],
            5 => ['Imperial Women’s Senior Wellness Check – 65+', 'imperial-womens-senior-wellness-65-plus.png'],
            6 => ['Imperial Women’s Heart Health Check', 'imperial-womens-heart-health.png'],
            7 => ['Imperial Men’s Senior Wellness Check – 65+', 'imperial-mens-senior-wellness-65-plus.png'],
            8 => ['Imperial Men’s Executive Health Check', 'imperial-mens-executive-health.png'],
        ];

        foreach ($packages as $id => [$name]) {
            HealthPackage::create([
                'id' => $id,
                'health_package_category_id' => $category->id,
                'name' => $name,
                'slug' => 'original-package-'.$id,
                'price' => 1000 + $id,
                'image' => 'assets/front/images/services/services-facility.jpg',
                'inclusions' => 'Test A'.PHP_EOL.'Test B',
                'description' => 'Original medical package description.',
                'status' => true,
                'show_on_frontend' => true,
                'sort_order' => $id,
            ]);
        }

        $before = HealthPackage::orderBy('id')->get()->mapWithKeys(function (HealthPackage $package) {
            $attributes = $package->getAttributes();
            unset($attributes['image'], $attributes['updated_at']);

            return [$package->id => $attributes];
        });

        $migration = require database_path('migrations/2026_08_17_000002_assign_approved_health_package_images.php');
        $migration->up();
        $migration->up();

        foreach ($packages as $id => [, $filename]) {
            $package = HealthPackage::findOrFail($id);
            $attributes = $package->getAttributes();
            unset($attributes['image'], $attributes['updated_at']);

            $this->assertSame('uploads/health_packages/'.$filename, $package->image);
            $this->assertSame($before[$id], $attributes);
        }

        $this->assertSame(8, HealthPackage::count());
    }
}
