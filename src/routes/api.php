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

                Route::namespace('Administration\Team')
                    ->prefix('administration')->as('administration.')
                    ->group(function () {
                        Route::get('teams/selectOptions', 'TeamSelectController@options')
                            ->name('teams.selectOptions');

                        Route::resource('teams', 'TeamController', ['only' => ['index', 'store', 'destroy']]);
                    });
            });
    });
