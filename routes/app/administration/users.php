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

        Route::post('{user}/token', 'Token')->name('token');

        Route::post('{user}/resetPassword', 'ResetPassword')->name('resetPassword');
    });
