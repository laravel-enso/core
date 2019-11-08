<?php

namespace LaravelEnso\Core;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\ActionLogger\app\Http\Middleware\ActionLogger;
use LaravelEnso\Core\app\Commands\ClearPreferences;
use LaravelEnso\Core\app\Commands\UpdateGlobalPreferences;
use LaravelEnso\Core\app\Commands\Upgrade;
use LaravelEnso\Core\app\Enums\UserGroups;
use LaravelEnso\Core\app\Http\Middleware\VerifyActiveState;
use LaravelEnso\Impersonate\app\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\app\Http\Middleware\SetLanguage;
use LaravelEnso\Permissions\app\Http\Middleware\VerifyRouteAccess;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Resource::withoutWrapping();

        $this->app->bind('user-groups', function () {
            return new UserGroups;
        });

        $this->addCommands()
            ->loadMiddleware()
            ->loadDependencies()
            ->publishDependencies()
            ->publishResources();
    }

    private function addCommands()
    {
        $this->commands(
            Upgrade::class,
            ClearPreferences::class,
            UpdateGlobalPreferences::class
        );

        return $this;
    }

    private function loadMiddleware()
    {
        $this->app['router']->aliasMiddleware(
            'verify-active-state', VerifyActiveState::class
        );

        $this->app['router']->middlewareGroup('core', [
            VerifyActiveState::class,
            ActionLogger::class,
            Impersonate::class,
            VerifyRouteAccess::class,
            SetLanguage::class,
        ]);

        return $this;
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/inspiring.php', 'enso.inspiring');

        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'enso.config');

        $this->mergeConfigFrom(__DIR__.'/config/auth.php', 'enso.auth');

        $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/core');

        return $this;
    }

    private function publishDependencies()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'core-config');

        $this->publishes([
            __DIR__.'/config' => config_path('enso'),
        ], 'enso-config');

        $this->publishes([
            __DIR__.'/resources/preferences.json' => resource_path('preferences.json'),
        ], 'core-preferences');

        $this->publishes([
            __DIR__.'/resources/preferences.json' => resource_path('preferences.json'),
        ], 'enso-preferences');

        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'core-factories');

        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], 'enso-factories');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'core-seeders');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'enso-seeders');

        return $this;
    }

    private function publishResources()
    {
        $this->publishes([
            __DIR__.'/storage' => storage_path('app'),
        ], 'core-storage');

        $this->publishes([
            __DIR__.'/resources/images' => resource_path('images'),
        ], 'core-images');

        $this->publishes([
            __DIR__.'/resources/views/mail' => resource_path('views/vendor/mail'),
        ], 'enso-email');
    }
}
