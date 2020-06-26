<?php

namespace LaravelEnso\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Core\Policies\User as Policy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => Policy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
