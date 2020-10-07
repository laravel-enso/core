<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Administration\User\Session\Destroy;
use LaravelEnso\Core\Http\Controllers\Administration\User\Session\Index;

Route::prefix('session')
    ->as('sessions.')
    ->group(function () {
        Route::get('{user}/index', Index::class)->name('index');
        Route::delete('{user}', Destroy::class)->name('destroy');
    });
