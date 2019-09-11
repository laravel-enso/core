<?php

namespace LaravelEnso\Core;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use LaravelEnso\Core\app\Listeners\LoginListener;
use LaravelEnso\Core\app\Listeners\PasswordResetListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [LoginListener::class],
        PasswordReset::class => [PasswordResetListener::class],
    ];
}
