<?php

use Illuminate\Support\Facades\Route;

Route::prefix('core')
    ->as('core.')
    ->group(function () {
        Route::get('home', 'Spa')->name('home.index');

        require 'core/preferences.php';
    });
