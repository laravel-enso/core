<?php

use Illuminate\Support\Facades\Route;

Route::namespace('LaravelEnso\Core\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        Route::get('/meta', 'Guest')->name('meta');

        require 'app/auth.php';

        Route::middleware(['api', 'auth'])
            ->group(fn () => Route::get('/sentry', 'Sentry')->name('sentry'));

        Route::middleware(['api', 'auth', 'core'])
            ->group(function () {
                require 'app/core.php';
                require 'app/administration.php';
            });
    });
