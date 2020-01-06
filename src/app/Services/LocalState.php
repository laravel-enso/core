<?php

namespace LaravelEnso\Core\App\Services;

use LaravelEnso\Core\App\Contracts\StateBuilder;

class LocalState implements StateBuilder
{
    public function build(): array
    {
        return [];
    }
}
