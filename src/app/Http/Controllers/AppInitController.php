<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Classes\StateBuilder;
use App\Http\Controllers\Controller;

class AppInitController extends Controller
{
    public function __invoke(StateBuilder $state)
    {
        return $state(auth()->user());
    }
}
