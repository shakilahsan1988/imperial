<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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