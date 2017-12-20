<?php

namespace LaravelEnso\Core;

use Illuminate\Auth\Events\Login;
use LaravelEnso\Core\app\Listeners\LogSuccessfulLoginListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            LogSuccessfulLoginListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
