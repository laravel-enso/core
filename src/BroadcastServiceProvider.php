<?php

namespace LaravelEnso\Core;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Broadcast::channel('app-updates', function () {
            return Auth::check();
        });
    }
}
