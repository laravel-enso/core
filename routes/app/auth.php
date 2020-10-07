<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Core\Http\Controllers\Auth\ForgotPasswordController;
use LaravelEnso\Core\Http\Controllers\Auth\LoginController;
use LaravelEnso\Core\Http\Controllers\Auth\ResetPasswordController;

Route::middleware('api')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::post('login', [LoginController::class, 'login'])
                ->name('login');
            Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
                ->name('password.email');
            Route::post('password/reset', [ResetPasswordController::class, 'attemptReset'])
                ->name('password.reset');
        });

        Route::middleware('auth')->group(function () {
            Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        });
    });
