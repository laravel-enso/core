<?php

namespace LaravelEnso\Core;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelEnso\Core\app\Listeners\LoginListener;
use LaravelEnso\Core\app\Listeners\PasswordResetListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [LoginListener::class],
        PasswordReset::class => [PasswordResetListener::class],
    ];
}
