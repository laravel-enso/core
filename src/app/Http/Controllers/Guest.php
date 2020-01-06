<?php

namespace LaravelEnso\Core\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Http\Responses\GuestState;

class Guest extends Controller
{
    public function __invoke()
    {
        return new GuestState();
    }
}
