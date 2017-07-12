<?php

Route::middleware(['web', 'auth', 'set-language'])
    ->namespace('LaravelEnso\Core\app\Http\Controllers')
    ->prefix('home')->as('home.')
    ->group(function () {
        Route::get('getTranslations', 'TranslationController')
            ->name('getTranslations');
    });

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\Core\app\Http\Controllers')
    ->group(function () {
        Route::prefix('core')->as('core.')
            ->group(function () {
                Route::prefix('preferences')->as('preferences.')
                    ->group(function () {
                        Route::patch('setPreferences/{route?}', 'PreferencesController@setPreferences')
                            ->name('setPreferences');
                        Route::post('resetToDefault/{route?}', 'PreferencesController@resetToDefault')
                            ->name('resetToDefault');
                    });
            });

        Route::prefix('administration')->as('administration.')
            ->group(function () {
                Route::prefix('owners')->as('owners.')
                    ->group(function () {
                        Route::get('initTable', 'OwnerController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'OwnerController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'OwnerController@exportExcel')
                            ->name('exportExcel');

                        Route::get('getOptionsList', 'OwnerController@getOptionsList')
                            ->name('getOptionsList');
                    });

                Route::resource('owners', 'OwnerController', ['except' => ['show']]);

                Route::prefix('users')->as('users.')
                    ->group(function () {
                        Route::get('initTable', 'UserController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'UserController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'UserController@exportExcel')
                            ->name('exportExcel');
                        // Route::post('setTableData', 'UserController@setTableData')
                        //     ->name('setTableData');

                        Route::patch('updateProfile/{user}', 'ProfilePageController')
                            ->name('updateProfile');
                    });

                Route::resource('users', 'UserController');
            });
    });
