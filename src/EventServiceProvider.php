<?php

namespace LaravelEnso\Core;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelEnso\Core\App\Events\Login;
use LaravelEnso\Core\App\Listeners\LoginListener;
use LaravelEnso\Core\App\Listeners\PasswordResetListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [LoginListener::class],
        PasswordReset::class => [PasswordResetListener::class],
    ];
}
