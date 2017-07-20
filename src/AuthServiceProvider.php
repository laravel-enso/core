<?php

namespace LaravelEnso\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        		\Gate::define('update-profile', function ($user, $profileUser) {
            return $user->id === $profileUser->id;
        });
    }
}
