<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api')
    ->namespace('LaravelEnso\Core\app\Http\Controllers')
    ->group(function () {
        Route::prefix('core')->as('core.')
            ->group(function () {
                Route::get('', 'SpaController')->name('index');

                Route::prefix('preferences')->as('preferences.')
                    ->group(function () {
                        Route::patch('setPreferences/{route?}', 'PreferencesController@setPreferences')
                            ->name('setPreferences');
                        Route::post('resetToDefault/{route?}', 'PreferencesController@resetToDefault')
                            ->name('resetToDefault');
                    });
            });
    });
