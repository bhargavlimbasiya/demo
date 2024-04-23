<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\v1'], function () {
    Route::controller(HomeController::class)->group(function () {
        Route::post('/sign-up', 'signUp');
        Route::post('/sign-in', 'signIn');
        Route::post('/forgot-password', 'forgotPassword');
        Route::post('/verify-pin', 'verifyPin')->name('verify-pin');
        Route::post('/reset-password', 'resetPassword')->name('reset-password');
        Route::post('/resend-otp', 'resendOtp')->name('resend-otp');
        Route::post('update-agreement', 'updateAgreement');
    });
    Route::controller(HomeController::class)->middleware('auth:sanctum')->group(function(){
        Route::post('/change-password', 'changePassword');
        Route::post('/get-user-detail', 'userDetail');
        Route::post('/update-profile', 'updateProfile');
        Route::get('/game-rule', 'gameRule');
    });

});    