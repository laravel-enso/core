<?php

namespace LaravelEnso\Core;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class PasswordServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $password = Config::get('enso.auth.password');

        Password::defaults(fn () => Password::min($password['minLength'])
            ->when($password['numeric'], fn ($pass) => $pass->numeric())
            ->when($password['special'], fn ($pass) => $pass->symbols())
            ->when($password['mixedCase'], fn ($pass) => $pass->mixedCase()));
    }
}
