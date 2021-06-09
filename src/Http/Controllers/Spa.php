<?php

namespace LaravelEnso\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Services\State\Builder;

class Spa extends Controller
{
    public function __invoke()
    {
        return (new Builder())->handle();
    }
}
