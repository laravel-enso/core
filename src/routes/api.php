<?php

use Illuminate\Support\Facades\Route;

Route::namespace('LaravelEnso\Core\App\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        Route::get('/meta', 'Guest')->name('meta');

        require 'app/auth.php';

        Route::middleware(['web', 'auth', 'core'])
            ->group(function () {
                require 'app/core.php';
                require 'app/administration.php';
            });
    });
