<?php

Route::namespace('LaravelEnso\Core\app\Http\Controllers')
    ->prefix('api')
    ->group(function () {
        Route::get('/meta', 'Guest')->name('meta');

        Route::namespace('Auth')
            ->middleware('web')
            ->group(function () {
                Route::post('login', 'LoginController@login')->name('login');
                Route::post('logout', 'LoginController@logout')->name('logout');
                Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                Route::post('password/reset', 'ResetPasswordController@attemptReset')->name('password.reset');
            });

        Route::middleware(['web', 'auth', 'core'])
            ->group(function () {
                Route::prefix('core')
                    ->as('core.')
                    ->group(function () {
                        Route::get('home', 'Spa')->name('home.index');

                        Route::namespace('Preferences')
                            ->prefix('preferences')
                            ->as('preferences.')
                            ->group(function () {
                                Route::patch('store/{route?}', 'Store')->name('store');
                                Route::post('reset/{route?}', 'Reset')->name('reset');
                            });
                    });

                Route::namespace('Administration')
                    ->prefix('administration')
                    ->as('administration.')
                    ->group(function () {
                        Route::namespace('UserGroup')
                            ->prefix('userGroups')
                            ->as('userGroups.')
                            ->group(function () {
                                Route::get('create', 'Create')->name('create');
                                Route::post('', 'Store')->name('store');
                                Route::get('{userGroup}/edit', 'Edit')->name('edit');
                                Route::patch('{userGroup}', 'Update')->name('update');
                                Route::delete('{userGroup}', 'Destroy')->name('destroy');

                                Route::get('initTable', 'InitTable')->name('initTable');
                                Route::get('tableData', 'TableData')->name('tableData');
                                Route::get('exportExcel', 'ExportExcel')->name('exportExcel');

                                Route::get('options', 'Options')->name('options');
                            });

                        Route::namespace('User')
                            ->prefix('users')
                            ->as('users.')
                            ->group(function () {
                                Route::get('create/{person}', 'Create')->name('create');
                                Route::post('', 'Store')->name('store');
                                Route::get('{user}/edit', 'Edit')->name('edit');
                                Route::patch('{user}', 'Update')->name('update');
                                Route::delete('{user}', 'Destroy')->name('destroy');

                                Route::get('initTable', 'InitTable')->name('initTable');
                                Route::get('tableData', 'TableData')->name('tableData');
                                Route::get('exportExcel', 'ExportExcel')->name('exportExcel');

                                Route::get('options', 'Options')->name('options');

                                Route::get('{user}', 'Show')->name('show');
                            });
                    });
            });
    });
