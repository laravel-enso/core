<?php

namespace LaravelEnso\Core\State;

use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Contracts\ProvidesState;

class Preferences implements ProvidesState
{
    public function mutation(): string
    {
        return 'preferences/set';
    }

    public function state(): mixed
    {
        return Auth::user()->preferences();
    }
}
