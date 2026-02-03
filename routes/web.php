<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::middleware(['Install', 'Locale'])->group(function () {
    
    // Loading sub-route files
    // Ensure these files exist in the routes directory
    require __DIR__.'/admin.php';
    require __DIR__.'/ajax.php';
    require __DIR__.'/patient.php';
    
});

// Localization Route
Route::get('change_locale/{lang}', [HomeController::class, 'change_locale'])->name('change_locale');

// System Utility Routes
Route::get('clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    
    return "System cache cleared successfully!";
});