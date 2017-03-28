<?php

Route::get('error/{error}', function () {
    return view('errors.'.request()->error);
});

Route::group(['namespace' => 'LaravelEnso\Core\app\Http\Controllers', 'middleware' => ['web', 'auth']], function () {
    Route::get('dashboard/getLineChartData', 'DashboardController@getLineChartData')->name('dashboard.getLineChartData');
    Route::get('dashboard/getBarChartData', 'DashboardController@getBarChartData')->name('dashboard.getBarChartData');
    Route::get('dashboard/getPieChartData', 'DashboardController@getPieChartData')->name('dashboard.getPieChartData');
    Route::get('dashboard/getRadarChartData', 'DashboardController@getRadarChartData')->name('dashboard.getRadarChartData');
    Route::get('dashboard/getPolarChartData', 'DashboardController@getPolarChartData')->name('dashboard.getPolarChartData');
    Route::get('dashboard/getBubbleChartData', 'DashboardController@getBubbleChartData')->name('dashboard.getBubbleChartData');
});

Route::group(['namespace' => 'LaravelEnso\Core\app\Http\Controllers', 'middleware' => ['web', 'auth', 'core']], function () {
    Route::get('/', 'Core\HomeController')->name('home');

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => 'export', 'as' => 'export.'], function () {
        Route::get('getUsers', 'ExportController@getUsers')->name('getUsers');
    });

    Route::group(['namespace' => 'Core', 'prefix' => 'core', 'as' => 'core.'], function () {
        Route::resource('avatars', 'AvatarController');

        Route::group(['prefix' => 'preferences', 'as' => 'preferences.'], function () {
            Route::patch('setPreferences', 'PreferencesController@setPreferences')->name('setPreferences');
            Route::post('resetToDefaut', 'PreferencesController@resetToDefaut')->name('resetToDefaut');
        });
    });

    Route::group(['namespace' => 'System', 'prefix' => 'system', 'as' => 'system.'], function () {
        Route::group(['prefix' => 'menus', 'as' => 'menus.'], function () {
            Route::get('reorder', 'MenusController@reorder')->name('reorder');
            Route::patch('setOrder', 'MenusController@setOrder')->name('setOrder');
            Route::patch('setAllocation', 'MenusController@setAllocation')->name('setAllocation');
            Route::get('initTable', 'MenusController@initTable')->name('initTable');
            Route::get('getTableData', 'MenusController@getTableData')->name('getTableData');
        });

        Route::resource('menus', 'MenusController');
        Route::group(['prefix' => 'permissionsGroups', 'as' => 'permissionsGroups.'], function () {
            Route::get('initTable', 'PermissionsGroupsController@initTable')->name('initTable');
            Route::get('getTableData', 'PermissionsGroupsController@getTableData')->name('getTableData');
        });

        Route::resource('permissionsGroups', 'PermissionsGroupsController');

        Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
            Route::get('initTable', 'PermissionsController@initTable')->name('initTable');
            Route::get('getTableData', 'PermissionsController@getTableData')->name('getTableData');
        });

        Route::resource('permissions', 'PermissionsController');

        Route::group(['prefix' => 'resourcePermissions', 'as' => 'resourcePermissions.'], function () {
            Route::get('create', 'ResourcePermissionsController@create')->name('create');
            Route::post('store', 'ResourcePermissionsController@store')->name('store');
        });

        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('initTable', 'RolesController@initTable')->name('initTable');
            Route::get('getTableData', 'RolesController@getTableData')->name('getTableData');
            Route::get('getPermissions/{role}', 'RolesController@getPermissions')->name('getPermissions');
            Route::get('getOptionsList', 'RolesController@getOptionsList')->name('getOptionsList');
            Route::post('setPermissions', 'RolesController@setPermissions')->name('setPermissions');
        });

        Route::resource('roles', 'RolesController');
    });
});
