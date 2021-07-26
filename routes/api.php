<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Guest;

Route::prefix('api')
    ->group(function () {
        Route::get('/meta', Guest::class)->name('meta');

        require __DIR__.'/app/auth.php';

        Route::middleware(['api', 'auth', 'core'])
            ->group(fn () => require __DIR__.'/app/core.php');
    });
