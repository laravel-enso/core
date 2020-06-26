<?php

namespace LaravelEnso\Core\Services;

use LaravelEnso\Core\Contracts\StateBuilder;

class LocalState implements StateBuilder
{
    public function build(): array
    {
        return [];
    }
}
