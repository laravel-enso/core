<?php

Route::group([
    'namespace'  => 'LaravelEnso\Core\app\Http\Controllers',
    'middleware' => ['web', 'auth', 'core'],
], function () {
    Route::group(['prefix' => 'core', 'as' => 'core.'], function () {
        Route::group(['prefix' => 'preferences', 'as' => 'preferences.'], function () {
            Route::patch('setPreferences/{route?}', 'PreferencesController@setPreferences')->name('setPreferences');
            Route::post('resetToDefault/{route?}', 'PreferencesController@resetToDefault')->name('resetToDefault');
        });
    });
});
