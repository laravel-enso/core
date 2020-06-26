<?php

namespace LaravelEnso\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use LaravelEnso\Core\Http\Responses\AppState;

class Spa extends Controller
{
    public function __invoke()
    {
        return App::make(AppState::class);
    }
}
