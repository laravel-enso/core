<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
use LaravelEnso\Core\app\Commands\ClearPreferences;
use LaravelEnso\Core\app\Commands\UpdateGlobalPreferences;
use LaravelEnso\Core\app\Http\Middleware\VerifyActiveState;
use LaravelEnso\Impersonate\app\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\app\Http\Middleware\SetLanguage;
use LaravelEnso\ActionLogger\app\Http\Middleware\ActionLogger;
use LaravelEnso\PermissionManager\app\Http\Middleware\VerifyRouteAccess;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Resource::withoutWrapping();

        $this->addCommands()
            ->loadMiddleware()
            ->loadDependencies()
            ->publishDependencies()
            ->publishResources();
    }

    private function addCommands()
    {
        $this->commands([
            ClearPreferences::class,
            UpdateGlobalPreferences::class,
        ]);

        return $this;
    }

    private function loadMiddleware()
    {
        $this->app['router']->middleware(
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
        $this->mergeConfigFrom(__DIR__.'/config/themes.php', 'enso.themes');
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
            __DIR__.'/resources/js' => resource_path('js'),
            __DIR__.'/resources/customizableJs' => resource_path('js'),
            __DIR__.'/resources/customizableSass' => resource_path('sass'),
            __DIR__.'/resources/customizableImages' => resource_path('images'),
            __DIR__.'/resources/sass' => resource_path('sass'),
            __DIR__.'/resources/images' => resource_path('images'),
        ], 'core-assets');

        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
            __DIR__.'/resources/sass' => resource_path('sass'),
            __DIR__.'/resources/images' => resource_path('images'),
        ], 'enso-assets');

        $this->publishes([
            __DIR__.'/resources/views/mail' => resource_path('views/vendor/mail'),
        ], 'enso-mail-assets');
    }

    public function register()
    {
        //
    }
}
