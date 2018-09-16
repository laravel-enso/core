<?php

Route::namespace('LaravelEnso\Core\app\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        Route::get('/meta', 'GuestController')
            ->name('meta');

        Route::namespace('Auth')
            ->middleware('web')
            ->group(function () {
                Route::post('login', 'LoginController@login')
                    ->name('login');
                Route::post('logout', 'LoginController@logout')
                    ->name('logout');
                Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
                    ->name('password.email');
                Route::post('password/reset', 'ResetPasswordController@reset')
                    ->name('password.reset');
            });

        Route::middleware(['web', 'auth', 'core'])
            ->group(function () {
                Route::prefix('core')->as('core.')
                    ->group(function () {
                        Route::get('', 'SpaController')->name('index');

                        Route::prefix('preferences')->as('preferences.')
                            ->group(function () {
                                Route::patch('setPreferences/{route?}', 'PreferencesController@setPreferences')
                                    ->name('setPreferences');
                                Route::post('resetToDefault/{route?}', 'PreferencesController@resetToDefault')
                                    ->name('setDefault');
                            });
                    });

                Route::namespace('Administration')
                    ->prefix('administration')->as('administration.')
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

                        Route::resource('owners', 'Owner\OwnerController', ['except' => ['show', 'index']]);

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

                        Route::resource('users', 'User\UserController', ['except' => ['index']]);

                        Route::namespace('Team')
                            ->prefix('team')->as('team.')
                            ->group(function () {
                                Route::get('selectOptions', 'TeamSelectController@options')
                                    ->name('selectOptions');
                            });

                        Route::resource('teams', 'Team\TeamController', ['only' => ['index', 'store', 'destroy']]);
                    });
            });
    });
