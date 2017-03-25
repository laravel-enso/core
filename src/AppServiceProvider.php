<?php

namespace LaravelEnso\Core;

use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\App\Http\Middleware\Impersonate;
use LaravelEnso\Core\App\Http\Middleware\VerifyActiveState;
use LaravelEnso\Core\App\Http\Middleware\VerifyRouteAccess;
use LaravelEnso\Core\App\Http\ViewComposers\BreadcrumbsComposer;
use LaravelEnso\Core\App\Http\ViewComposers\MainComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesAll();
        $this->registerMiddleware();
        $this->loadDependencies();
        $this->registerComposers();
    }

    private function publishesAll()
    {
        $this->publishesDepedencies();
        $this->publishesClasses();
        $this->publishesViews();
        $this->publishesResources();
    }

    private function publishesDepedencies()
    {
        $this->publishes([
            __DIR__.'/config/laravel-enso.php' => config_path('laravel-enso.php'),
        ], 'core-config');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'core-migration');

        $this->publishes([
            __DIR__.'/resources/routes/web.php' => base_path('routes/web.php'),
        ], 'core-routes');

        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang'),
        ], 'core-lang');
    }

    private function publishesClasses()
    {
        $this->publishes([
            __DIR__.'/resources/Classes/DataTable' => app_path('DataTable'),
        ], 'core-classes');

        $this->publishes([
            __DIR__.'/resources/Classes/Controllers' => app_path('Http/Controllers'),
        ], 'core-controllers');

        $this->publishes([
            __DIR__.'/resources/Classes/Requests' => app_path('Http/Requests'),
        ], 'core-requests');

        $this->publishes([
            __DIR__.'/resources/Classes/Models' => app_path(),
        ], 'core-models');

        $this->publishes([
            __DIR__.'/app/notifications' => app_path('Notifications/vendor/laravel-enso'),
        ], 'core-notification');
    }

    private function publishesViews()
    {
        $this->publishes([
            __DIR__.'/resources/views/layouts' => resource_path('views/vendor/laravel-enso/core/layouts'),
        ], 'core-views');

        $this->publishes([
            __DIR__.'/resources/views/partials' => resource_path('views/vendor/laravel-enso/core/partials'),
        ], 'core-views');

        $this->publishes([
            __DIR__.'/resources/views/includes' => resource_path('views/vendor/laravel-enso/core/includes'),
        ], 'core-views');

        $this->publishes([
            __DIR__.'/resources/views/pages' => resource_path('views/vendor/laravel-enso/core/pages'),
        ], 'core-views');

        $this->publishes([
            __DIR__.'/resources/views/auth' => resource_path('views/auth'),
        ], 'core-auth');

        $this->publishes([
            __DIR__.'/resources/views/errors' => resource_path('views/errors'),
        ], 'core-errors');
    }

    private function publishesResources()
    {
        $this->publishes([
            __DIR__.'/resources/assets/images' => resource_path('assets/images'),
        ], 'core-images');

        $this->publishes([
            __DIR__.'/resources/assets/js' => resource_path('assets/js/vendor/laravel-enso'),
        ], 'core-pages-js');

        $this->publishes([
            __DIR__.'/resources/assets/libs' => resource_path('assets/libs'),
        ], 'core-libs');

        $this->publishes([
            __DIR__.'/resources/assets/main-js' => resource_path('assets/js'),
        ], 'core-main-js');

        $this->publishes([
            __DIR__.'/resources/assets/sass' => resource_path('assets/sass'),
        ], 'core-sass');

        $this->publishes([
            __DIR__.'/resources/assets/root' => base_path(),
        ], 'core-root');
    }

    private function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('impersonate', Impersonate::class);
        $this->app['router']->aliasMiddleware('verifyActiveState', VerifyActiveState::class);
        $this->app['router']->aliasMiddleware('verifyRouteAccess', VerifyRouteAccess::class);
        $this->app['router']->aliasMiddleware('setLanguage', SetLanguage::class);
    }

    private function loadDependencies()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-enso/core');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    private function registerComposers()
    {
        view()->composer('laravel-enso/core::layouts.app',
            MainComposer::class);

        view()->composer('laravel-enso/core::partials.breadcrumbs',
            BreadcrumbsComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
