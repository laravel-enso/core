<?php

use Illuminate\Support\Facades\Route;

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
