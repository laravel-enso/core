<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Login\ExportExcel;
use LaravelEnso\Core\Http\Controllers\Login\InitTable;
use LaravelEnso\Core\Http\Controllers\Login\TableData;

Route::get('initTable', InitTable::class)->name('initTable');
Route::get('tableData', TableData::class)->name('tableData');
Route::get('exportExcel', ExportExcel::class)->name('exportExcel');
