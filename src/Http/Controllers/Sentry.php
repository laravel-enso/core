<?php

namespace LaravelEnso\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Exceptions\Sentry as Handler;

class Sentry extends Controller
{
    public function __invoke()
    {
        return ['eventId' => Handler::eventId()];
    }
}
