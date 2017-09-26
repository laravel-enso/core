<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\StateBuilder;

class AppInitController extends Controller
{
    public function __invoke(StateBuilder $state)
    {
        return $state(auth()->user());
    }
}
