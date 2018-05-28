<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Http\Responses\GuestState;

class GuestController extends Controller
{
    public function __invoke()
    {
        return new GuestState();
    }
}
