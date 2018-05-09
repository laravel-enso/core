<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\ActionLogger\app\Http\Middleware\ActionLogger;
use LaravelEnso\Core\app\Http\Middleware\VerifyActiveState;
use LaravelEnso\Core\app\Http\ViewComposers\MainComposer;
use LaravelEnso\Impersonate\app\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\app\Http\Middleware\SetLanguage;
use LaravelEnso\PermissionManager\app\Http\Middleware\VerifyRouteAccess;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishesDependencies();
        $this->publishesResources();
        $this->registerMiddleware();
        $this->loadDependencies();
        $this->registerComposers();
    }

    private function publishesDependencies()
    {
        $this->publishes([
            __DIR__.'/config' => config_path(),
        ], 'core-config');

        $this->publishes([
            __DIR__.'/config' => config_path(),
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
    }

    private function publishesResources()
    {
        $this->publishes([
            __DIR__.'/storage' => storage_path('app'),
        ], 'core-storage');

        $this->publishes([
            __DIR__.'/resources/assets/js/modules'     => resource_path('assets/js/vendor/laravel-enso/modules'),
            __DIR__.'/resources/assets/js/enso.js'     => resource_path('assets/js/enso.js'),
            __DIR__.'/resources/assets/js/defaults.js' => resource_path('assets/js/defaults.js'),
        ], 'core-js');

        $this->publishes([
            __DIR__.'/resources/assets/sass' => resource_path('assets/sass'),
        ], 'core-sass');

        $this->publishes([
            __DIR__.'/resources/assets/js/modules'     => resource_path('assets/js/vendor/laravel-enso/modules'),
            __DIR__.'/resources/assets/sass'           => resource_path('assets/sass'),
            __DIR__.'/resources/assets/js/enso.js'     => resource_path('assets/js/enso.js'),
            __DIR__.'/resources/assets/js/defaults.js' => resource_path('assets/js/defaults.js'),
            __DIR__.'/resources/views/emails'          => resource_path('views/vendor/laravel-enso/core/emails'),
            __DIR__.'/resources/assets/images'         => resource_path('assets/images'),
        ], 'enso-update');

        $this->publishes([
            __DIR__.'/resources/views/emails'  => resource_path('views/vendor/laravel-enso/core/emails'),
            __DIR__.'/resources/assets/images' => resource_path('assets/images'),
        ], 'core-email-templates');

        $this->publishes([
            __DIR__.'/resources/views/emails'  => resource_path('views/vendor/laravel-enso/core/emails'),
            __DIR__.'/resources/assets/images' => resource_path('assets/images'),
        ], 'email-templates');
    }

    private function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('verify-active-state', VerifyActiveState::class);

        $this->app['router']->middlewareGroup('core', [
            VerifyActiveState::class,
            ActionLogger::class,
            VerifyRouteAccess::class,
            Impersonate::class,
            SetLanguage::class,
        ]);
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravel-enso.php', 'laravel-enso');
        $this->mergeConfigFrom(__DIR__.'/config/inspiring.php', 'inspiring');
        $this->mergeConfigFrom(__DIR__.'/config/labels.php', 'labels');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/core');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    private function registerComposers()
    {
        view()->composer('laravel-enso/core::layouts.app',
            MainComposer::class);
    }

    public function register()
    {
        //
    }
}
