<?php

namespace LaravelEnso\Core\State;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\Contracts\ProvidesState;

class Themes implements ProvidesState
{
    public function store(): string
    {
        return 'layout';
    }

    public function state(): array
    {
        return ['themes' => Config::get('enso.themes')];
    }
}
