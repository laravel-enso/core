<?php

Route::middleware(['auth:api', 'api', 'core'])
    ->prefix('api')
    ->namespace('LaravelEnso\Core\app\Http\Controllers')
    ->group(function () {
        Route::get('/init', 'AppInitController')->name('init');

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
                Route::namespace('Owner')
                    ->prefix('owners')->as('owners.')
                    ->group(function () {
                        Route::get('initTable', 'OwnerTableController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'OwnerTableController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'OwnerTableController@exportExcel')
                            ->name('exportExcel');

                        Route::get('getOptionList', 'OwnerSelectController@getOptionList')
                            ->name('getOptionList');
                    });

                Route::resource('owners', 'Owner\OwnerController', ['except' => ['show']]);

                Route::namespace('User')
                    ->prefix('users')->as('users.')
                    ->group(function () {
                        Route::get('initTable', 'UserTableController@initTable')
                            ->name('initTable');
                        Route::get('getTableData', 'UserTableController@getTableData')
                            ->name('getTableData');
                        Route::get('exportExcel', 'UserTableController@exportExcel')
                            ->name('exportExcel');
                        Route::get('getOptionList', 'UserSelectController@getOptionList')
                            ->name('getOptionList');

                        Route::patch('updateProfile/{user}', 'ProfilePageController')
                            ->name('updateProfile');
                    });

                Route::resource('users', 'User\UserController');
            });
    });
