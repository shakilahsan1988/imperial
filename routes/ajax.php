<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| These routes handle asynchronous requests from your diagnostic system.
| Ensuring 'web' middleware is active for CSRF protection.
|
*/

Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'middleware' => ['web']], function () {

    // Patient related AJAX
    Route::get('get_patient_by_code', [AjaxController::class, 'get_patient_by_code'])->name('get_patient_by_code'); 
    Route::get('get_patient_by_name', [AjaxController::class, 'get_patient_by_name'])->name('get_patient_by_name'); 
    Route::get('get_patient', [AjaxController::class, 'get_patient'])->name('get_patient'); 
    Route::post('create_patient', [AjaxController::class, 'create_patient'])->name('create_patient');
   
    // Test related AJAX
    Route::get('get_tests', [AjaxController::class, 'get_tests'])->name('get_tests');
    Route::get('delete_test/{test_id}', [AjaxController::class, 'delete_test'])->name('delete_test');
    Route::get('delete_option/{option_id}', [AjaxController::class, 'delete_option'])->name('delete_option');

    // Culture and Doctor AJAX
    Route::get('get_cultures', [AjaxController::class, 'get_cultures'])->name('get_cultures');
    Route::get('get_doctors', [AjaxController::class, 'get_doctors'])->name('get_doctors');
    Route::post('create_doctor', [AjaxController::class, 'create_doctor'])->name('create_doctor');

    // Options management
    Route::post('add_sample_type', [AjaxController::class, 'add_sample_type'])->name('add_sample_type');
    Route::post('add_organism', [AjaxController::class, 'add_organism'])->name('add_organism');
    Route::post('add_colony_count', [AjaxController::class, 'add_colony_count'])->name('add_colony_count');
    
    // Roles
    Route::get('get_roles', [AjaxController::class, 'get_roles'])->name('get_roles');  

    // Admin authenticated AJAX
    Route::middleware(['Admin'])->group(function () {
        Route::post('change_visit_status/{id}', [AjaxController::class, 'change_visit_status'])->name('change_visit_status');
        Route::post('change_lang_status/{id}', [AjaxController::class, 'change_lang_status'])->name('change_lang_status');
        Route::post('add_expense_category', [AjaxController::class, 'add_expense_category'])->name('add_expense_category');
        Route::get('get_new_visits', [AjaxController::class, 'get_new_visits'])->name('get_new_visits');
    });
    
    // Patient authenticated AJAX
    Route::middleware(['Patient'])->group(function () {
        Route::get('get_current_patient', [AjaxController::class, 'get_current_patient'])->name('get_current_patient');
    });

});