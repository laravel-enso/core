<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Administration\User\Create;
use LaravelEnso\Core\Http\Controllers\Administration\User\Destroy;
use LaravelEnso\Core\Http\Controllers\Administration\User\Edit;
use LaravelEnso\Core\Http\Controllers\Administration\User\ExportExcel;
use LaravelEnso\Core\Http\Controllers\Administration\User\InitTable;
use LaravelEnso\Core\Http\Controllers\Administration\User\Options;
use LaravelEnso\Core\Http\Controllers\Administration\User\ResetPassword;
use LaravelEnso\Core\Http\Controllers\Administration\User\Show;
use LaravelEnso\Core\Http\Controllers\Administration\User\Store;
use LaravelEnso\Core\Http\Controllers\Administration\User\TableData;
use LaravelEnso\Core\Http\Controllers\Administration\User\Update;

Route::prefix('users')
    ->as('users.')
    ->group(function () {
        Route::get('create/{person}', Create::class)->name('create');
        Route::post('', Store::class)->name('store');
        Route::get('{user}/edit', Edit::class)->name('edit');
        Route::patch('{user}', Update::class)->name('update');
        Route::delete('{user}', Destroy::class)->name('destroy');

        Route::get('initTable', InitTable::class)->name('initTable');
        Route::get('tableData', TableData::class)->name('tableData');
        Route::get('exportExcel', ExportExcel::class)->name('exportExcel');

        Route::get('options', Options::class)->name('options');

        Route::get('{user}', Show::class)->name('show');

        Route::post('{user}/resetPassword', ResetPassword::class)->name('resetPassword');

        require 'token/tokens.php';
        require 'session/sessions.php';
    });
