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
                    ->name('login')->middleware('throttle:'.config('enso.auth.maxLoginAttempts').',1');
                Route::post('logout', 'LoginController@logout')
                    ->name('logout');
                Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
                    ->name('password.email');
                Route::post('password/reset', 'ResetPasswordController@attemptReset')
                    ->name('password.reset');
            });

        Route::middleware(['web', 'auth', 'core'])
            ->group(function () {
                Route::prefix('core')->as('core.')
                    ->group(function () {
                        Route::get('home', 'SpaController')->name('home.index');

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
                        Route::namespace('UserGroup')
                            ->prefix('userGroups')->as('userGroups.')
                            ->group(function () {
                                Route::get('initTable', 'UserGroupTableController@init')
                                    ->name('initTable');
                                Route::get('tableData', 'UserGroupTableController@data')
                                    ->name('tableData');
                                Route::get('exportExcel', 'UserGroupTableController@excel')
                                    ->name('exportExcel');

                                Route::get('options', 'UserGroupSelectController@options')
                                    ->name('options');
                            });

                        Route::resource('userGroups', 'UserGroup\UserGroupController', ['except' => ['show', 'index']]);

                        Route::namespace('User')
                            ->prefix('users')->as('users.')
                            ->group(function () {
                                Route::get('create/{person}', 'UserController@create')
                                    ->name('create');

                                Route::get('initTable', 'UserTableController@init')
                                    ->name('initTable');
                                Route::get('tableData', 'UserTableController@data')
                                    ->name('tableData');
                                Route::get('exportExcel', 'UserTableController@excel')
                                    ->name('exportExcel');

                                Route::get('options', 'UserSelectController@options')
                                    ->name('options');
                            });

                        Route::resource('users', 'User\UserController', ['except' => ['index', 'create']]);
                    });
            });
    });
