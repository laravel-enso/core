<?php

namespace LaravelEnso\Core;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use LaravelEnso\Core\app\Policies\UserPolicies;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies;

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->policies = [
            config('auth.providers.users.model') => UserPolicies::class,
        ];

        $this->registerPolicies();

        \Gate::define('accessRoute', function ($user, $route) {
            return $user->hasAccessTo($route);
        });
    }
}
