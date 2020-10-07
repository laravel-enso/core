<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Preferences\Reset;
use LaravelEnso\Core\Http\Controllers\Preferences\Store;

Route::prefix('preferences')
    ->as('preferences.')
    ->group(function () {
        Route::patch('store/{route?}', Store::class)->name('store');
        Route::post('reset/{route?}', Reset::class)->name('reset');
    });
