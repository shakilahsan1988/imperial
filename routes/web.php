<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/
Route::prefix('front')->group(function () {
    Route::get('/', [FrontController::class, 'index'])->name('fhome');
    Route::get('/services', [FrontController::class, 'services'])->name('services');
    Route::get('/service-details', [FrontController::class, 'service_details'])->name('service-details');
    Route::get('/health-check', [FrontController::class, 'health_check'])->name('health-check');
    Route::get('/membership', [FrontController::class, 'membership'])->name('membership');
    Route::get('/lab-test', [FrontController::class, 'lab_test'])->name('lab-test');
    Route::get('/video-consultation', [FrontController::class, 'video_consultation'])->name('video-consultation');
    Route::get('/beauty', [FrontController::class, 'beauty'])->name('beauty');
    Route::get('/about', [FrontController::class, 'about'])->name('about');
    Route::get('/about-details', [FrontController::class, 'about_details'])->name('about-details');
    Route::get('/bill-of-right', [FrontController::class, 'bill_of_rights'])->name('bill-of-right');
    Route::get('/career', [FrontController::class, 'career'])->name('career');
    Route::get('/career-details', [FrontController::class, 'career_details'])->name('career-details');
    Route::get('/code-of-ethics', [FrontController::class, 'code_ethics'])->name('code-of-ethics');
    Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
    Route::get('/client', [FrontController::class, 'client'])->name('client');
    Route::get('/management', [FrontController::class, 'management'])->name('management');
    Route::get('/management-details', [FrontController::class, 'management_details'])->name('management-details');
    Route::get('/mission-vision-value', [FrontController::class, 'mission_vision_value'])->name('mission-vision-value');
    
 
    Route::get('/privacy-notice', [FrontController::class, 'privacy_notice'])->name('privacy-notice');
    
    Route::get('/doctor', [FrontController::class, 'doctor'])->name('doctor');
    Route::get('/book-doctor', [FrontController::class, 'book_doctor'])->name('book-doctor');
    Route::get('/blog', [FrontController::class, 'blog'])->name('blog');
    Route::get('/blog-details', [FrontController::class, 'blog_details'])->name('blog-details');
    Route::get('/event', [FrontController::class, 'event'])->name('event');
    Route::get('/event-details', [FrontController::class, 'event_details'])->name('event-details');
    Route::get('/press', [FrontController::class, 'press'])->name('press');
    Route::get('/press-details', [FrontController::class, 'press_details'])->name('press-details');
    Route::get('/gallery', [FrontController::class, 'gallery'])->name('gallery');
});

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