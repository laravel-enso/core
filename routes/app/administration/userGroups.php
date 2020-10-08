<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\Create;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\Destroy;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\Edit;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\ExportExcel;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\InitTable;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\Options;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\Store;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\TableData;
use LaravelEnso\Core\Http\Controllers\Administration\UserGroup\Update;

Route::prefix('userGroups')
    ->as('userGroups.')
    ->group(function () {
        Route::get('create', Create::class)->name('create');
        Route::post('', Store::class)->name('store');
        Route::get('{userGroup}/edit', Edit::class)->name('edit');
        Route::patch('{userGroup}', Update::class)->name('update');
        Route::delete('{userGroup}', Destroy::class)->name('destroy');

        Route::get('initTable', InitTable::class)->name('initTable');
        Route::get('tableData', TableData::class)->name('tableData');
        Route::get('exportExcel', ExportExcel::class)->name('exportExcel');

        Route::get('options', Options::class)->name('options');
    });
