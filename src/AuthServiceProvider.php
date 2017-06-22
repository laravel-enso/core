<?php

namespace LaravelEnso\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use LaravelEnso\Core\app\Policies\UserPolicies;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies;

    public function boot()
    {
        $this->policies = [
            config('auth.providers.users.model') => UserPolicies::class,
        ];

        $this->registerPolicies();
    }
}
