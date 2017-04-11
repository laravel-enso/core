<?php

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('getLineChartData', 'DashboardController@getLineChartData')->name('getLineChartData');
    Route::get('getBarChartData', 'DashboardController@getBarChartData')->name('getBarChartData');
    Route::get('getPieChartData', 'DashboardController@getPieChartData')->name('getPieChartData');
    Route::get('getRadarChartData', 'DashboardController@getRadarChartData')->name('getRadarChartData');
    Route::get('getPolarChartData', 'DashboardController@getPolarChartData')->name('getPolarChartData');
    Route::get('getBubbleChartData', 'DashboardController@getBubbleChartData')->name('getBubbleChartData');
});

Route::group(['middleware' => ['auth', 'core']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

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
