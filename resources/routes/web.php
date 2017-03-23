<?php

Auth::routes();

Route::group(['middleware' => ['auth', 'core']], function () {
    Route::group(['namespace' => 'Administration', 'prefix' => 'administration', 'as' => 'administration.'], function () {
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
