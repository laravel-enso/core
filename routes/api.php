<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Guest;
use LaravelEnso\Core\Http\Controllers\Sentry;

Route::prefix('api')
    ->group(function () {
        Route::get('/meta', Guest::class)->name('meta');

        require 'app/auth.php';

        Route::middleware(['api', 'auth'])
            ->group(fn () => Route::get('/sentry', Sentry::class)->name('sentry'));

        Route::middleware(['api', 'auth', 'core'])
            ->group(function () {
                require 'app/core.php';
                require 'app/administration.php';
            });
    });
