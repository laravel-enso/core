<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Guest;
use LaravelEnso\Core\Http\Controllers\Sentry;

Route::prefix('api')
    ->group(function () {
        Route::get('/meta', Guest::class)->name('meta');

        require __DIR__.'/app/auth.php';

        Route::middleware(['api', 'auth'])
            ->group(fn () => Route::get('/sentry', Sentry::class)->name('sentry'));

        Route::middleware(['api', 'auth', 'core'])
            ->group(fn () => require __DIR__.'/app/core.php');
    });
