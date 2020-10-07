<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Spa;

Route::prefix('core')
    ->as('core.')
    ->group(function () {
        Route::get('home', Spa::class)->name('home.index');

        require 'core/preferences.php';
    });
