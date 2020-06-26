<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Administration')
    ->prefix('administration')
    ->as('administration.')
    ->group(function () {
        require 'administration/userGroups.php';
        require 'administration/users.php';
    });
