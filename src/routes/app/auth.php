<?php

Route::namespace('Auth')
    ->middleware('web')
    ->group(function () {
        Route::post('login', 'LoginController@login')->name('login');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::post('password/reset', 'ResetPasswordController@attemptReset')->name('password.reset');
    });
