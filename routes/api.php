<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\GroupTestsController;
use App\Http\Controllers\Api\VisitsController;
use App\Http\Controllers\Api\BranchesController;
use App\Http\Controllers\Api\TestsLibraryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. 
|
*/

// Authorization routes (Public)
Route::post('register', [ApiController::class, 'register'])->name('register');
Route::post('login', [ApiController::class, 'login'])->name('login');
Route::post('forget_code', [ApiController::class, 'forget_code']);

// Patient Dashboard routes (Protected)
Route::group(['prefix' => 'patient', 'middleware' => 'auth:api'], function () {
    Route::get('dashboard', [ProfileController::class, 'dashboard']);
    Route::post('update_profile', [ProfileController::class, 'update_profile']);
    Route::get('group_tests', [GroupTestsController::class, 'group_tests']);
    Route::post('visit', [VisitsController::class, 'store']);
    Route::get('branches', [BranchesController::class, 'index']);
    Route::get('tests', [TestsLibraryController::class, 'tests']);
    Route::get('cultures', [TestsLibraryController::class, 'cultures']);
});