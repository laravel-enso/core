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

        Route::prefix('administration')->as('administration.')
            ->group(function () {
                Route::namespace('Owner')
                    ->prefix('owners')->as('owners.')
                    ->group(function () {
                        Route::get('initTable', 'OwnerTableController@init')
                            ->name('initTable');
                        Route::get('getTableData', 'OwnerTableController@data')
                            ->name('getTableData');
                        Route::get('exportExcel', 'OwnerTableController@excel')
                            ->name('exportExcel');

                        Route::get('selectOptions', 'OwnerSelectController@options')
                            ->name('selectOptions');
                    });

                Route::resource('owners', 'Owner\OwnerController', ['except' => ['show']]);

                Route::namespace('User')
                    ->prefix('users')->as('users.')
                    ->group(function () {
                        Route::get('initTable', 'UserTableController@init')
                            ->name('initTable');
                        Route::get('getTableData', 'UserTableController@data')
                            ->name('getTableData');
                        Route::get('exportExcel', 'UserTableController@excel')
                            ->name('exportExcel');
                        Route::get('selectOptions', 'UserSelectController@options')
                            ->name('selectOptions');
                    });

                Route::resource('users', 'User\UserController');
            });
    });
