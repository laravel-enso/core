<?php

use Illuminate\Support\Facades\Route;

Route::prefix('administration')
    ->as('administration.')
    ->group(function () {
        require 'administration/users.php';
    });
