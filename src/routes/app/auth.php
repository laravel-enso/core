<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')
    ->middleware('api')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::post('login', 'LoginController@login')->name('login');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::post('password/reset', 'ResetPasswordController@attemptReset')->name('password.reset');
        });
        Route::middleware('auth')->group(function () {
            Route::post('logout', 'LoginController@logout')->name('logout');
        });
    });
