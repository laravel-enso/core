<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\StateBuilder;

class SpaController extends Controller
{
    public function __invoke()
    {
        return new StateBuilder;
    }
}
