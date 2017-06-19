<?php

Route::group([
    'namespace' => 'LaravelEnso\Core\app\Http\Controllers',
    'middleware' => ['web', 'auth', 'core']
], function () {
    Route::get('/', 'Core\HomeController')->name('home');

    Route::group(['prefix' => 'export', 'as' => 'export.'], function () {
        Route::get('getUsers', 'ExportController@getUsers')->name('getUsers');
    });

    Route::group(['namespace' => 'Core', 'prefix' => 'core', 'as' => 'core.'], function () {
        Route::group(['prefix' => 'preferences', 'as' => 'preferences.'], function () {
            Route::patch('setPreferences/{route?}', 'PreferencesController@setPreferences')->name('setPreferences');
            Route::post('resetToDefault/{route?}', 'PreferencesController@resetToDefault')->name('resetToDefault');
        });
    });
});
