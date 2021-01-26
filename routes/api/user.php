<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user')->namespace('API\User')->middleware('apilogger')->group(function () {
    /**
     * Auth Routes
     */
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('verify-sms', 'AuthController@verifySMS');
    // Route::post('resend-sms', 'AuthController@resendSMS');
    // Route::post('forget-password', 'AuthController@forgetPassword');
    // Route::post('reset-password', 'AuthController@resetPassword');

    Route::middleware(['api', 'multiauth:user'])->group(function () {

        // profile
        // Route::post('update-profile', 'AuthController@updateProfile');
        // Route::post('update-phone-number', 'AuthController@updatePhoneNumber');
        // Route::post('update-phone-number-verify-sms', 'AuthController@verifySMSForUpdatePhone');
        // Route::post('update-phone-number/resend-sms', 'AuthController@resendSMSForUpdatePhone');
        // Route::post('change-password', 'AuthController@changePassword');
        Route::get('profile', 'AuthController@profile');
        Route::get('logout', 'AuthController@logout');
    });
});
