<?php

namespace LaravelEnso\Core\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Exceptions\Sentry as Handler;

class Sentry extends Controller
{
    public function __invoke()
    {
        return ['eventId' => Handler::eventId()];
    }
}
