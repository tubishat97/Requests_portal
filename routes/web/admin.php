<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->name('admin.')->group(function () {
    Route::get('/login', 'Auth\AuthController@showLoginForm')->name('login_form');
    Route::post('/login', 'Auth\AuthController@login')->name('login');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

        Route::get('/profile', 'UserController@profile')->name('profile');
        Route::post('/profile/update', 'UserController@updateProfile')->name('profile.update');

        Route::resource('customer', 'CustomerController')->name('*', 'customer');

        Route::resource('flight', 'FlightController')->name('*', 'flight');

        Route::resource('airport', 'AirportController')->name('*', 'airport');

        Route::resource('airplane', 'AirplaneController')->name('*', 'airplane');

        Route::resource('airline', 'AirlineController')->name('*', 'airline');
    });
});
