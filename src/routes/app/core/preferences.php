<?php

Route::namespace('Preferences')
    ->prefix('preferences')
    ->as('preferences.')
    ->group(function () {
        Route::patch('store/{route?}', 'Store')->name('store');
        Route::post('reset/{route?}', 'Reset')->name('reset');
    });
