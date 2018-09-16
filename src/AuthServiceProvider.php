<?php

namespace LaravelEnso\Core;

use Laravel\Horizon\Horizon;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Horizon::auth(function ($request) {
            return auth()->check() && $request->user()->isAdmin();
        });
    }
}
