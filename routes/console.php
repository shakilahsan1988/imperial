<?php

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use App\Services\DoctorDataSyncService;
use Database\Seeders\ServiceSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Display an inspiring quote
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Custom command to clear all diagnostic system cache at once
 * Useful for bdCoder IT Park developers during updates
 */
Artisan::command('system:clear', function () {
    $this->info('Clearing all system cache...');
    Artisan::call('optimize:clear');
    $this->comment('System cache cleared successfully!');
})->purpose('Clear all application cache, config, and views');

/**
 * Command to clean up old activity logs (Optional)
 * Helps keep the diagnostic database light
 */
Artisan::command('logs:clean', function () {
    $this->info('Cleaning up old activity logs...');
    // Add logic to delete logs older than 30 days if using Spatie
    Artisan::call('activitylog:clean');
    $this->comment('Old logs removed.');
})->purpose('Clean up activity logs to save database space');

Artisan::command('catalog:import-lab-tests', function () {
    $this->info('Importing lab-test catalog from the lab-test directory...');
    $this->line('Source files: TEST_NAME_WITH_PRICE.xlsx, USG, Echo, ECG.xlsx, DuplexStudy.xlsx');
    $this->line('Skipped file: X-RAY NEW SOFTWARE.xlsx');
    $this->line('Classification rule: USG Guided FNAC => Procedures > Cytopathology');

    Artisan::call('db:seed', ['--class' => ServiceSeeder::class, '--no-interaction' => true], $this->output);

    $this->newLine();
    $this->info('Lab-test catalog import completed.');
    $this->table(
        ['Metric', 'Count'],
        [
            ['Active categories', ServiceCategory::where('status', true)->count()],
            ['Active subcategories', ServiceSubCategory::where('status', true)->count()],
            ['Active laboratory services', Service::where('status', true)->where('category', 'laboratory')->count()],
            ['Active imaging services', Service::where('status', true)->where('category', 'imaging')->count()],
            ['Active procedure services', Service::where('status', true)->where('category', 'procedure')->count()],
        ]
    );
})->purpose('Refresh the lab-test catalog from Excel files in the lab-test directory');

Artisan::command('catalog:replace-imaging {filePath}', function () {
    $filePath = $this->argument('filePath');

    if (! is_file($filePath)) {
        $this->error('File not found: '.$filePath);

        return self::FAILURE;
    }

    $this->info('Replacing imaging catalog from Excel file...');
    $this->line('Source: '.$filePath);

    $rows = IOFactory::load($filePath)->getActiveSheet()->toArray('', true, true, true);
    $imagingCategory = ServiceCategory::withTrashed()->firstOrCreate(
        ['slug' => 'imaging'],
        [
            'name' => 'Imaging',
            'type' => 'imaging',
            'description' => 'Radiology and diagnostic imaging services',
            'status' => true,
            'sort_order' => 2,
        ]
    );

    if ($imagingCategory->trashed()) {
        $imagingCategory->restore();
    }

    $summary = DB::transaction(function () use ($rows, $imagingCategory) {
        $existingSubCategoryIds = ServiceSubCategory::withTrashed()
            ->where('service_category_id', $imagingCategory->id)
            ->pluck('id');

        Service::withTrashed()
            ->where('category', 'imaging')
            ->forceDelete();

        if ($existingSubCategoryIds->isNotEmpty()) {
            ServiceSubCategory::withTrashed()
                ->whereIn('id', $existingSubCategoryIds)
                ->forceDelete();
        }

        $subCategory = ServiceSubCategory::create([
            'service_category_id' => $imagingCategory->id,
            'name' => 'X-Ray',
            'slug' => 'x-ray',
            'status' => true,
            'sort_order' => 1,
        ]);

        $inserted = 0;

        foreach ($rows as $index => $row) {
            if ($index <= 2) {
                continue;
            }

            $name = trim((string) ($row['E'] ?? ''));
            $price = preg_replace('/[^0-9.]+/', '', trim((string) ($row['I'] ?? '')));

            if ($name === '' || $price === '' || ! is_numeric($price)) {
                continue;
            }

            Service::create([
                'name' => $name,
                'short_name' => trim((string) ($row['D'] ?? '')) ?: null,
                'category' => 'imaging',
                'sub_category' => $subCategory->name,
                'service_category_id' => $imagingCategory->id,
                'service_sub_category_id' => $subCategory->id,
                'price' => (float) $price,
                'home_visit_available' => false,
                'show_on_frontend' => true,
                'status' => true,
                'sort_order' => $inserted + 1,
            ]);

            $inserted++;
        }

        $imagingCategory->update(['status' => $inserted > 0]);

        return [
            'inserted' => $inserted,
            'subcategories' => ServiceSubCategory::where('service_category_id', $imagingCategory->id)->count(),
        ];
    });

    $this->newLine();
    $this->table(
        ['Metric', 'Count'],
        [
            ['Imported imaging services', $summary['inserted']],
            ['Imaging subcategories', $summary['subcategories']],
            ['Active imaging services', Service::where('category', 'imaging')->where('status', true)->count()],
        ]
    );

    return self::SUCCESS;
})->purpose('Hard replace imaging services from a source Excel file');

Artisan::command('doctor:sync-source {sourceDir} {--purge}', function (DoctorDataSyncService $service) {
    $sourceDir = $this->argument('sourceDir');

    $this->info('Syncing doctor data from source directory...');
    $this->line('Source: ' . $sourceDir);
    $this->line('Purge existing data: ' . ($this->option('purge') ? 'yes' : 'no'));

    $summary = $service->syncFromDirectory($sourceDir, (bool) $this->option('purge'));

    $this->newLine();
    $this->table(
        ['Metric', 'Count'],
        [
            ['Profile rows', $summary['profiles_count']],
            ['Schedule rows', $summary['schedule_count']],
            ['Doctors imported', $summary['created_count']],
            ['Doctors with matched profiles', $summary['matched_profile_count']],
            ['Doctors using avatar fallback', $summary['avatar_fallback_count']],
        ]
    );

    $this->info('Doctor sync completed.');
})->purpose('Purge and sync doctor records from an Excel/image source directory');
