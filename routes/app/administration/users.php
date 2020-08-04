<?php

use Illuminate\Support\Facades\Route;

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

        Route::namespace('Token')
            ->prefix('token')
            ->as('tokens.')
            ->group(function () {
                Route::get('{user}', 'Create')->name('create');
                Route::post('{user}', 'Store')->name('store');
                Route::get('{user}/index', 'Index')->name('index');
                Route::delete('{user}', 'Destroy')->name('destroy');
            });

        Route::post('{user}/resetPassword', 'ResetPassword')->name('resetPassword');

        Route::namespace('Session')
            ->prefix('session')
            ->as('sessions.')
            ->group(function () {
                Route::get('{user}/index', 'Index')->name('index');
                Route::delete('{user}', 'Destroy')->name('destroy');
            });
    });
