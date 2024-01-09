<?php

namespace LaravelEnso\Core\State;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\Contracts\ProvidesState;

class Themes implements ProvidesState
{
    public function mutation(): string
    {
        return 'layout/setThemes';
    }

    public function state(): mixed
    {
        return Config::get('enso.themes');
    }
}
