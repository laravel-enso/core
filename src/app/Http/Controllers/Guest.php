<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Http\Responses\GuestState;

class Guest extends Controller
{
    public function __invoke()
    {
        return new GuestState();
    }
}
