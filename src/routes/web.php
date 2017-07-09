<?php

Route::group([
    'prefix'     => 'home', 'as' => 'home.',
    'namespace'  => 'LaravelEnso\Core\app\Http\Controllers',
    'middleware' => ['web', 'auth', 'set-language'],
], function () {
    Route::get('getTranslations', 'TranslationController')->name('getTranslations');
});

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

    Route::group(['prefix' => 'export', 'as' => 'export.'], function () {
        Route::get('getUsers', 'ExportController@getUsers')->name('getUsers');
    });

    Route::group(['prefix' => 'administration', 'as' => 'administration.'], function () {
        Route::group(['prefix' => 'owners', 'as' => 'owners.'], function () {
            Route::get('initTable', 'OwnerController@initTable')->name('initTable');
            Route::get('getTableData', 'OwnerController@getTableData')->name('getTableData');
            Route::get('getOptionsList', 'OwnerController@getOptionsList')->name('getOptionsList');
        });

        Route::resource('owners', 'OwnerController');

        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('initTable', 'UserController@initTable')->name('initTable');
            Route::get('getTableData', 'UserController@getTableData')->name('getTableData');
            Route::post('setTableData', 'UserController@setTableData')->name('setTableData');

            Route::patch('updateProfile/{user}', 'ProfilePageController')->name('updateProfile');
        });

        Route::resource('users', 'UserController');
    });
});
