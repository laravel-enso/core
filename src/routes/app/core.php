<?php

Route::middleware(['web', 'auth', 'core'])
    ->group(function () {
        Route::prefix('core')
            ->as('core.')
            ->group(function () {
                Route::get('home', 'Spa')->name('home.index');

                require 'core/preferences.php';
            });

            require 'core/administration.php';
    });
