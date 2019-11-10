<?php

namespace LaravelEnso\Core\app\Services;

use LaravelEnso\Core\app\Contracts\StateBuilder;

class LocalState implements StateBuilder
{
    public function build()
    {
        return [];
    }
}
