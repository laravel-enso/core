<?php

namespace LaravelEnso\Core\State;

use LaravelEnso\Core\Contracts\ProvidesState;
use LaravelEnso\Core\Enums\Themes as Enum;

class Themes implements ProvidesState
{
    public function mutation(): string
    {
        return 'layout/setThemes';
    }

    public function state(): mixed
    {
        return Enum::all();
    }
}
