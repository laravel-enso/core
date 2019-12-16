<?php

Route::namespace('LaravelEnso\Core\app\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        Route::get('/meta', 'Guest')->name('meta');

        require 'app/auth.php';
        require 'app/core.php';
    });
