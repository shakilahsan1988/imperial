<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\TestsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AntibioticsController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\CulturesController;
use App\Http\Controllers\Admin\CultureOptionsController;
use App\Http\Controllers\Admin\GroupsController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PricesController;
use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\VisitsController;
use App\Http\Controllers\Admin\BranchesController;
use App\Http\Controllers\Admin\ContractsController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\ExpenseCategoriesController;
use App\Http\Controllers\Admin\BackupsController;
use App\Http\Controllers\Admin\ActivityLogsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TranslationsController;

// Admin Authentication (Guest)
Route::group(['prefix' => 'admin/auth', 'middleware' => 'AdminGuest', 'as' => 'admin.auth.'], function() {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'login_submit'])->name('login_submit');
});

// Logout Admin
Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout')->middleware('Admin');

// Reset Admin Password
Route::group(['prefix' => 'admin/reset', 'as' => 'admin.reset.'], function() {
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

    // Tests
    Route::resource('tests', TestsController::class);
    Route::get('get_tests', [TestsController::class, 'ajax'])->name('get_tests');
    
    // Antibiotics
    Route::resource('antibiotics', AntibioticsController::class);
    Route::get('get_antibiotics', [AntibioticsController::class, 'ajax'])->name('get_antibiotics');
    
    // Patients
    Route::resource('patients', PatientsController::class);
    Route::get('get_patients', [PatientsController::class, 'ajax'])->name('get_patients'); 
    Route::get('patients_export', [PatientsController::class, 'export'])->name('patients.export'); 
    Route::get('patients_download_template', [PatientsController::class, 'download_template'])->name('patients.download_template'); 
    Route::post('patients_import', [PatientsController::class, 'import'])->name('patients.import'); 

    // Cultures
    Route::resource('cultures', CulturesController::class);
    Route::get('get_cultures', [CulturesController::class, 'ajax'])->name('get_cultures');

    // Culture Options
    Route::resource('culture_options', CultureOptionsController::class);
    Route::get('get_culture_options', [CultureOptionsController::class, 'ajax'])->name('culture_options.ajax');
   
    // Groups
    Route::resource('groups', GroupsController::class);
    Route::post('groups/delete_analysis/{id}', [GroupsController::class, 'delete_analysis']);
    Route::get('get_groups', [GroupsController::class, 'ajax'])->name('get_groups');
    Route::post('groups/print_barcode/{group_id}', [GroupsController::class, 'print_barcode'])->name('groups.print_barcode');
   
    // Doctors 
    Route::resource('doctors', DoctorsController::class);
    Route::get('get_doctors', [DoctorsController::class, 'ajax'])->name('get_doctors');
    Route::get('doctors_export', [DoctorsController::class, 'export'])->name('doctors.export'); 
    Route::get('doctors_download_template', [DoctorsController::class, 'download_template'])->name('doctors.download_template'); 
    Route::post('doctors_import', [DoctorsController::class, 'import'])->name('doctors.import'); 

    // Reports
    Route::resource('reports', ReportsController::class);
    Route::post('reports/pdf/{id}', [ReportsController::class, 'pdf'])->name('reports.pdf');
    Route::post('reports/update_culture/{id}', [ReportsController::class, 'update_culture'])->name('reports.update_culture');
    Route::get('get_reports', [ReportsController::class, 'ajax'])->name('get_reports');
    Route::get('sign_report/{id}', [ReportsController::class, 'sign'])->name('reports.sign');
    
    // Roles
    Route::resource('roles', RolesController::class);
    Route::get('get_roles', [RolesController::class, 'ajax'])->name('get_roles');

    // Users
    Route::resource('users', UsersController::class);
    Route::get('get_users', [UsersController::class, 'ajax'])->name('get_users');
   
    // Prices
    Route::get('prices/tests', [PricesController::class, 'tests'])->name('prices.tests');
    Route::post('prices/tests', [PricesController::class, 'tests_submit'])->name('prices.tests_submit');
    Route::get('tests_prices_export', [PricesController::class, 'tests_prices_export'])->name('prices.tests_prices_export'); 
    Route::post('tests_prices_import', [PricesController::class, 'tests_prices_import'])->name('prices.tests_prices_import'); 
  
    Route::get('prices/cultures', [PricesController::class, 'cultures'])->name('prices.cultures');
    Route::post('prices/cultures', [PricesController::class, 'cultures_submit'])->name('prices.cultures_submit');
    Route::get('cultures_prices_export', [PricesController::class, 'cultures_prices_export'])->name('prices.cultures_prices_export'); 
    Route::post('cultures_prices_import', [PricesController::class, 'cultures_prices_import'])->name('prices.cultures_prices_import'); 
    
    // Accounting
    Route::get('accounting', [AccountingController::class, 'index'])->name('accounting.index');
    Route::get('generate_report', [AccountingController::class, 'generate_report'])->name('accounting.generate_report');
    Route::get('doctor_report', [AccountingController::class, 'doctor_report'])->name('accounting.doctor_report');
    Route::get('generate_doctor_report', [AccountingController::class, 'generate_doctor_report'])->name('accounting.generate_doctor_report');
    
    // Chat
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
   
    // Visits
    Route::resource('visits', VisitsController::class);
    Route::get('visits/create_tests/{id}', [VisitsController::class, 'create_tests'])->name('visits.create_tests');
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

    // Translations
    Route::resource('translations', TranslationsController::class);
});