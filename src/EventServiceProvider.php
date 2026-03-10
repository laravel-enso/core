<?php

namespace LaravelEnso\Core;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use LaravelEnso\Core\Events\Login;
use LaravelEnso\Core\Listeners\LoginListener;
use LaravelEnso\Core\Listeners\PasswordResetListener;
use LaravelEnso\Core\Observers\User as Observer;
use LaravelEnso\Users\Models\User;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [LoginListener::class],
        PasswordReset::class => [PasswordResetListener::class],
    ];

    public function boot()
    {
        $user = App::make(User::class);

        $user::observe(Observer::class);
    }
}
