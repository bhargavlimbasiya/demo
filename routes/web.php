<?php

use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset-password-new');
Route::post('otp-verify', [ResetPasswordController::class, 'otpVerify'])->name('otp-verify');



Route::group(['namespace' => 'App\Http\Controllers'], function ($admin) {

    $admin->post('sent-mail-forgot-password', [ForgotPasswordController::class, 'sendForgotPasswordEmailResetPassword'])->name('admin-sent-mail-forgot-password');;
});

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('update-password');
    Route::post('/update-profile', [AuthController::class, 'profileUpdate'])->name('update-profile');
    Route::resource('admin-users', UserController::class);
    Route::get('change-status', [UserController::class, 'changeUserStatus'])->name('change-status');
    Route::get('user-list-admin', [UserController::class, 'userAjaxList'])->name('user-list-admin');

    Route::resource('categories', CategoryController::class);
    Route::get('category-list', [CategoryController::class, 'ajaxList'])->name('category-list');
    Route::get('change-category-status', [CategoryController::class, 'changeUserStatus'])->name('change-category-status');
    Route::post('category-bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category-bulk-delete');
});
