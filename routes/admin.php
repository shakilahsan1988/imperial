<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PricesController;
use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\VisitsController;
use App\Http\Controllers\Admin\BranchesController;
use App\Http\Controllers\Admin\ContractsController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\ExpenseCategoriesController;
use App\Http\Controllers\Admin\BackupsController;
use App\Http\Controllers\Admin\ActivityLogsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PageSettingsController;
use App\Http\Controllers\Admin\TranslationsController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\ServiceCategoriesController;
use App\Http\Controllers\Admin\ServiceSubCategoriesController;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\HealthPackageCategoriesController;
use App\Http\Controllers\Admin\HealthPackagesController;
use App\Http\Controllers\Admin\HealthPackageBookingsController;
use App\Http\Controllers\Admin\DoctorSpecialtiesController;
use App\Http\Controllers\Admin\DoctorDepartmentsController;
use App\Http\Controllers\Admin\DoctorConsultationSlotsController;
use App\Http\Controllers\Admin\DoctorConsultationBookingsController;
use App\Http\Controllers\Admin\MembershipCategoriesController;
use App\Http\Controllers\Admin\MembershipPlansController;
use App\Http\Controllers\Admin\MembershipPlanBookingsController;

// Admin Authentication (Guest)
Route::group(['prefix' => 'admin', 'middleware' => 'AdminGuest', 'as' => 'admin.'], function() {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'login_submit'])->name('login_submit');
});

// Logout Admin
Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout')->middleware('Admin');

// Reset Admin Password
Route::group(['prefix' => 'admin/reset', 'as' => 'admin.'], function() {
    Route::get('/mail', [AdminController::class, 'mail'])->name('mail');
    Route::post('/mail_submit', [AdminController::class, 'mail_submit'])->name('mail_submit');
    Route::get('/reset_password_form/{token}', [AdminController::class, 'reset_password_form'])->name('reset_password_form');
    Route::post('/reset_password_submit', [AdminController::class, 'reset_password_submit'])->name('reset_password_submit');
});

// Admin Controls (Authenticated)
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['web', 'Admin']], function() {
    
    // Dashboard
    Route::get('/', [IndexController::class, 'index'])->name('index'); 

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('update', [ProfileController::class, 'update'])->name('update');
    });

    // Manage Services
    Route::resource('service_categories', ServiceCategoriesController::class);
    Route::get('get_service_sub_categories', [ServiceSubCategoriesController::class, 'ajax'])->name('service_sub_categories.ajax');
    Route::resource('service_sub_categories', ServiceSubCategoriesController::class);

    // Services
    Route::get('get_services_ajax', [ServicesController::class, 'ajax'])->name('services.ajax');
    Route::resource('services', ServicesController::class);

    // Bookings
    Route::resource('bookings', BookingsController::class);
    Route::get('get_bookings', [BookingsController::class, 'ajax'])->name('get_bookings');
    Route::patch('bookings/{booking}/status', [BookingsController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('bookings/patients', [BookingsController::class, 'getPatients'])->name('bookings.patients');
    Route::get('bookings/{booking}/create_report', [BookingsController::class, 'createReport'])->name('bookings.create_report');

    // Results (Completed Bookings)
    Route::get('results', [BookingsController::class, 'results'])->name('results.index');

    // Patients
    Route::resource('patients', PatientsController::class);
    Route::get('get_patients', [PatientsController::class, 'ajax'])->name('get_patients'); 
    Route::get('patients_export', [PatientsController::class, 'export'])->name('patients.export'); 
    Route::get('patients_download_template', [PatientsController::class, 'download_template'])->name('patients.download_template'); 
    Route::post('patients_import', [PatientsController::class, 'import'])->name('patients.import'); 

    // Groups
    Route::resource('groups', GroupsController::class);
    Route::get('get_groups', [GroupsController::class, 'ajax'])->name('get_groups');
    Route::post('groups/print_barcode/{group_id}', [GroupsController::class, 'print_barcode'])->name('groups.print_barcode');
   
    // Doctors 
    Route::resource('doctors', DoctorsController::class);
    Route::get('get_doctors', [DoctorsController::class, 'ajax'])->name('get_doctors');
    Route::get('doctors_export', [DoctorsController::class, 'export'])->name('doctors.export'); 
    Route::get('doctors_download_template', [DoctorsController::class, 'download_template'])->name('doctors.download_template'); 
    Route::post('doctors_import', [DoctorsController::class, 'import'])->name('doctors.import'); 

    // Reports
    Route::get('reports/{id}/pdf', [ReportsController::class, 'pdf'])->name('reports.pdf');
    Route::resource('reports', ReportsController::class);
    Route::get('get_reports', [ReportsController::class, 'ajax'])->name('get_reports');
    
    // Roles
    Route::resource('roles', RolesController::class);
    Route::get('get_roles', [RolesController::class, 'ajax'])->name('get_roles');

    // Users
    Route::resource('users', UsersController::class);
    Route::get('get_users', [UsersController::class, 'ajax'])->name('get_users');
   
    // Accounting
    Route::get('accounting', [AccountingController::class, 'index'])->name('accounting.index');
    Route::get('generate_report', [AccountingController::class, 'generate_report'])->name('accounting.generate_report');
    Route::get('doctor_report', [AccountingController::class, 'doctor_report'])->name('accounting.doctor_report');
    Route::get('generate_doctor_report', [AccountingController::class, 'generate_doctor_report'])->name('accounting.generate_doctor_report');
    
    // Visits
    Route::resource('visits', VisitsController::class);
    Route::get('get_visits', [VisitsController::class, 'ajax'])->name('get_visits');
   
    // Branches
    Route::resource('branches', BranchesController::class);
    Route::get('get_branches', [BranchesController::class, 'ajax'])->name('get_branches');
    
    // Contracts
    Route::resource('contracts', ContractsController::class);
    Route::get('get_contracts', [ContractsController::class, 'ajax'])->name('get_contracts');
   
    // Expenses
    Route::resource('expenses', ExpensesController::class);
    Route::get('get_expenses', [ExpensesController::class, 'ajax'])->name('get_expenses');
    
    // Expense Categories
    Route::resource('expense_categories', ExpenseCategoriesController::class);
    Route::get('get_expense_categories', [ExpenseCategoriesController::class, 'ajax'])->name('get_expense_categories');

    // Backups
    Route::resource('backups', BackupsController::class);

    // Activity Logs
    Route::resource('activity_logs', ActivityLogsController::class);
    Route::post('activity_logs_clear', [ActivityLogsController::class, 'clear'])->name('activity_logs.clear');
    Route::get('get_activity_logs', [ActivityLogsController::class, 'ajax'])->name('get_activity_logs');

    // Settings
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('info', [SettingsController::class, 'info_submit'])->name('info_submit');
        Route::post('emails', [SettingsController::class, 'emails_submit'])->name('emails_submit');
        Route::post('reports', [SettingsController::class, 'reports_submit'])->name('reports_submit');
        Route::post('sms', [SettingsController::class, 'sms_submit'])->name('sms_submit');
        Route::post('whatsapp', [SettingsController::class, 'whatsapp_submit'])->name('whatsapp_submit');
        Route::post('api_keys', [SettingsController::class, 'api_keys_submit'])->name('api_keys_submit');
    });

    // Page Settings
    Route::group(['prefix' => 'pages', 'as' => 'pages.'], function() {
        Route::get('home-settings', [PageSettingsController::class, 'homeSettings'])->name('home_settings');
        Route::post('home-settings', [PageSettingsController::class, 'updateHomeSettings'])->name('home_settings_submit');
        Route::get('diagonostic-settings', [PageSettingsController::class, 'diagonosticSettings'])->name('diagonostic_settings');
        Route::post('diagonostic-settings', [PageSettingsController::class, 'updateDiagonosticSettings'])->name('diagonostic_settings_submit');
        Route::get('health-check-settings', [PageSettingsController::class, 'healthCheckSettings'])->name('health_check_settings');
        Route::post('health-check-settings', [PageSettingsController::class, 'updateHealthCheckSettings'])->name('health_check_settings_submit');
    });

    // Translations
    Route::resource('translations', TranslationsController::class);

    // Health Check
    Route::resource('health_package_categories', HealthPackageCategoriesController::class)->except(['show']);
    Route::resource('health_packages', HealthPackagesController::class)->except(['show']);
    Route::resource('health_package_bookings', HealthPackageBookingsController::class)->only(['index', 'show', 'update']);

    // Membership
    Route::resource('membership_categories', MembershipCategoriesController::class)->except(['show']);
    Route::resource('membership_plans', MembershipPlansController::class)->except(['show']);
    Route::resource('membership_plan_bookings', MembershipPlanBookingsController::class)->only(['index', 'show', 'update']);

    // Manage Doctors
    Route::resource('doctor_specialties', DoctorSpecialtiesController::class)->except(['show']);
    Route::resource('doctor_departments', DoctorDepartmentsController::class)->except(['show']);
    Route::resource('doctor_consultation_slots', DoctorConsultationSlotsController::class)->except(['show']);
    Route::resource('doctor_consultation_bookings', DoctorConsultationBookingsController::class)->only(['index', 'show', 'update']);
});
