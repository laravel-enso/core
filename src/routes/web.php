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

    Route::group(['prefix' => 'export', 'as' => 'export.'], function () {
        Route::get('getUsers', 'ExportController@getUsers')->name('getUsers');
    });

    Route::group(['prefix' => 'administration', 'as' => 'administration.'], function () {
        Route::group(['prefix' => 'owners', 'as' => 'owners.'], function () {
            Route::get('initTable', 'OwnersController@initTable')->name('initTable');
            Route::get('getTableData', 'OwnersController@getTableData')->name('getTableData');
            Route::get('getOptionsList', 'OwnersController@getOptionsList')->name('getOptionsList');
        });

        Route::resource('owners', 'OwnersController');

        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('initTable', 'UsersController@initTable')->name('initTable');
            Route::get('getTableData', 'UsersController@getTableData')->name('getTableData');
            Route::post('setTableData', 'UsersController@setTableData')->name('setTableData');
            Route::patch('updateProfile/{user}', 'UsersController@updateProfile')->name('updateProfile');
            Route::get('{id}/impersonate', 'UsersController@impersonate')->name('impersonate');
            Route::get('stopImpersonating', 'UsersController@stopImpersonating')->name('stopImpersonating');
        });

        Route::resource('users', 'UsersController');
    });
});