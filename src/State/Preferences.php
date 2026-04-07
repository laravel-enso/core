<?php

namespace LaravelEnso\Core\State;

use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Contracts\ProvidesState;

class Preferences implements ProvidesState
{
    public function store(): string
    {
        return 'preferences';
    }

    public function state(): array
    {
        return Auth::user()->preferences->value;
    }
}
