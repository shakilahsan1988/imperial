<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PatientController;
use App\Http\Controllers\Patient\IndexController;
use App\Http\Controllers\Patient\GroupsController;
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\Patient\VisitsController;
use App\Http\Controllers\Patient\BranchesController;
use App\Http\Controllers\Patient\TestsLibraryController;

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/

// Patient authentication (Guest routes)
Route::group(['prefix' => '/', 'middleware' => 'PatientGuest', 'as' => 'patient.auth.'], function() {
    
    // Registration
    Route::get('register', [PatientController::class, 'showRegistrationForm'])->name('register');
    Route::post('register_submit', [PatientController::class, 'register_submit'])->name('register_submit');
    
    // Login
    Route::get('/', [PatientController::class, 'showLoginForm'])->name('login');
    Route::post('/login_submit', [PatientController::class, 'login_submit'])->name('login_submit');
    
    // Patient Code/Mail
    Route::get('/mail', [PatientController::class, 'showMailForm'])->name('mail');
    Route::post('/mail_submit', [PatientController::class, 'mail_submit'])->name('mail_submit');
    
    // Quick login via code
    Route::get('patient/login/{code}', [PatientController::class, 'login_patient'])->name('login_by_code');
});

// Logout patient
Route::post('/logout', [PatientController::class, 'logout'])->name('patient.logout');

// Patient pages (Authenticated routes)
Route::group(['prefix' => 'patient', 'middleware' => 'Patient', 'as' => 'patient.'], function() {
    
    // Dashboard
    Route::get('/', [IndexController::class, 'index'])->name('index');
    
    // Reports and Receipts
    Route::group(['prefix' => 'groups', 'as' => 'groups.'], function() {
        Route::get('/', [GroupsController::class, 'index'])->name('index');
        Route::get('/reports/{id}', [GroupsController::class, 'reports'])->name('reports');
        Route::get('/receipt/{id}', [GroupsController::class, 'receipt'])->name('receipt');
        Route::post('/reports/pdf/{id}', [GroupsController::class, 'pdf'])->name('pdf');
    });
    
    // AJAX data for groups
    Route::get('get_patient_groups', [GroupsController::class, 'ajax'])->name('get_patient_groups');

    // Profile Management
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/', [ProfileController::class, 'update'])->name('update');
    });

    // Resourceful Routes
    Route::resource('visits', VisitsController::class);
    Route::resource('branches', BranchesController::class);
    Route::resource('tests_library', TestsLibraryController::class);
    
    // Tests Library AJAX
    Route::get('get_analyses', [TestsLibraryController::class, 'get_analyses']);
    Route::get('get_cultures', [TestsLibraryController::class, 'get_cultures']);
});