<?php

namespace LaravelEnso\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies;

    public function boot()
    {
        $this->policies = [
            User::class => UserPolicy::class,
        ];

        $this->registerPolicies();
    }
}
