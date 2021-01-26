<?php

use Illuminate\Support\Facades\Route;

Route::prefix('customer')->namespace('API\Customer')->middleware('apilogger')->group(function () {

    # Auth Routes
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('verify-sms', 'AuthController@verifySMS');
    Route::post('resend-sms', 'AuthController@resendSMS');
    Route::post('forget-password', 'AuthController@forgetPassword');
    Route::post('reset-password', 'AuthController@resetPassword');
    Route::post('social/login', 'AuthController@socialLogin');
    Route::get('search', 'FlightController@search');

    Route::middleware(['api', 'multiauth:customer'])->group(function () {

        # profile
        Route::post('social/link', 'AuthController@linkSocialAccount');
        Route::post('receive-notification', 'CustomerNotificationController@receiveNotification');
        Route::post('change-password', 'AuthController@changePassword');
        Route::get('profile', 'AuthController@profile');
        Route::post('profile', 'AuthController@updateProfile');
        Route::post('verify-sms-phone', 'AuthController@verifySMSPhone');
        Route::get('logout', 'AuthController@logout');
    });
});
