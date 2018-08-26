<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\app\Commands\ClearPreferences;
use LaravelEnso\Core\app\Commands\UpgradeFileManager;
use LaravelEnso\Core\app\Http\Middleware\VerifyActiveState;
use LaravelEnso\Impersonate\app\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\app\Http\Middleware\SetLanguage;
use LaravelEnso\ActionLogger\app\Http\Middleware\ActionLogger;
use LaravelEnso\PermissionManager\app\Http\Middleware\VerifyRouteAccess;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishesDependencies();
        $this->publishesResources();
        $this->registerMiddleware();
        $this->loadDependencies();

        $this->commands([
            ClearPreferences::class,
            UpgradeFileManager::class,
        ]);
    }

    private function publishesDependencies()
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
            __DIR__.'/resources/lang' => resource_path('lang'),
        ], 'core-lang');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'core-seeder');

        $this->publishes([
            __DIR__.'/database/seeds' => database_path('seeds'),
        ], 'enso-seeders');

    }

    private function publishesResources()
    {
        $this->publishes([
            __DIR__.'/storage' => storage_path('app'),
        ], 'core-storage');

        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js'),
            __DIR__.'/resources/assets/sass' => resource_path('assets/sass'),
            __DIR__.'/resources/assets/images' => resource_path('assets/images'),
        ], 'core-assets');

        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js'),
            __DIR__.'/resources/assets/sass' => resource_path('assets/sass'),
            __DIR__.'/resources/assets/images' => resource_path('assets/images'),
        ], 'enso-assets');

        $this->publishes([
            __DIR__.'/resources/views/mail' => resource_path('views/vendor/mail'),
            __DIR__.'/resources/assets/images' => resource_path('assets/images'),
        ], 'enso-mail-assets');

        $this->publishes([
            __DIR__.'/resources/views/emails' => resource_path('views/vendor/laravel-enso/core/emails'),
        ], 'core-mail');

        $this->publishes([
            __DIR__.'/resources/views/emails' => resource_path('views/vendor/laravel-enso/core/emails'),
        ], 'enso-mail');
    }

    private function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('verify-active-state', VerifyActiveState::class);

        $this->app['router']->middlewareGroup('core', [
            VerifyActiveState::class,
            ActionLogger::class,
            Impersonate::class,
            VerifyRouteAccess::class,
            SetLanguage::class,
        ]);
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/inspiring.php', 'enso.inspiring');
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'enso.config');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/core');
    }

    public function register()
    {
        //
    }
}
