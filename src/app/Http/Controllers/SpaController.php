<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Http\Responses\AppState;

class SpaController extends Controller
{
    public function __invoke()
    {
        return new AppState;
    }
}
