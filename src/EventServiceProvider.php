<?php

namespace LaravelEnso\Core;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelEnso\Core\app\Listeners\LogSuccessfulLoginListener;

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
