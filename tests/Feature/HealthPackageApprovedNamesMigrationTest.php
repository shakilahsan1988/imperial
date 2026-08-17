<?php

namespace Tests\Feature;

use App\Models\HealthPackage;
use App\Models\HealthPackageCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthPackageApprovedNamesMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renames_only_the_verified_master_names_and_is_idempotent(): void
    {
        $category = HealthPackageCategory::create([
            'name' => 'Wellness',
            'slug' => 'wellness',
            'status' => true,
            'sort_order' => 0,
        ]);

        $names = [
            1 => ['Her Health (Under 40)', 'Imperial Women’s Wellness Check – Under 40'],
            2 => ['Her Health (40 - 65)', 'Imperial Women’s Wellness Check – 40 to 65'],
            3 => ['His Health (Under 40)', 'Imperial Men’s Wellness Check – Under 40'],
            4 => ['His Health (40 - 65)', 'Imperial Men’s Wellness Check – 40 to 65'],
            5 => ['Her Health (Above 65)', 'Imperial Women’s Senior Wellness Check – 65+'],
            6 => ["Women's Cardiac Check", 'Imperial Women’s Heart Health Check'],
            7 => ['His Health (Above 65)', 'Imperial Men’s Senior Wellness Check – 65+'],
            8 => ["Men's Executive Check", 'Imperial Men’s Executive Health Check'],
        ];

        foreach ($names as $id => [$oldName]) {
            HealthPackage::create([
                'id' => $id,
                'health_package_category_id' => $category->id,
                'name' => $oldName,
                'slug' => 'original-package-'.$id,
                'price' => 1000 + $id,
                'inclusions' => 'Test A'.PHP_EOL.'Test B',
                'description' => 'Original medical package description.',
                'status' => true,
                'show_on_frontend' => true,
                'sort_order' => $id,
            ]);
        }

        $before = HealthPackage::orderBy('id')->get()->mapWithKeys(function (HealthPackage $package) {
            $attributes = $package->getAttributes();
            unset($attributes['name'], $attributes['updated_at']);

            return [$package->id => $attributes];
        });

        $migration = require database_path('migrations/2026_08_17_000001_rename_health_packages_to_approved_imperial_names.php');
        $migration->up();
        $migration->up();

        foreach ($names as $id => [, $newName]) {
            $package = HealthPackage::findOrFail($id);
            $attributes = $package->getAttributes();
            unset($attributes['name'], $attributes['updated_at']);

            $this->assertSame($newName, $package->name);
            $this->assertSame($before[$id], $attributes);
            $this->assertSame('original-package-'.$id, $package->slug);
        }

        $this->assertSame(8, HealthPackage::count());
        $this->assertSame(8, HealthPackage::distinct()->count('name'));
    }
}
