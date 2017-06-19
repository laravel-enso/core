<?php

namespace LaravelEnso\Core;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\ActionLogger\app\Http\Middleware\ActionLogger;
use LaravelEnso\Core\app\Http\Middleware\VerifyActiveState;
use LaravelEnso\Core\app\Http\ViewComposers\BreadcrumbsComposer;
use LaravelEnso\Core\app\Http\ViewComposers\MainComposer;
use LaravelEnso\Impersonate\app\Http\Middleware\Impersonate;
use LaravelEnso\Localisation\app\Http\Middleware\SetLanguage;
use LaravelEnso\PermissionManager\app\Http\Middleware\VerifyRouteAccess;

class CoreServiceProvider extends ServiceProvider
{
    private $providers = [
        'Collective\Html\HtmlServiceProvider',
        'Laracasts\Flash\FlashServiceProvider',
        'LaravelEnso\ActionLogger\ActionLoggerServiceProvider',
        'LaravelEnso\AvatarManager\AvatarManagerServiceProvider',
        'LaravelEnso\Core\AuthServiceProvider',
        'LaravelEnso\Charts\ChartsServiceProvider',
        'LaravelEnso\DataTable\DataTableServiceProvider',
        'LaravelEnso\Core\EventServiceProvider',
        'LaravelEnso\FileManager\FileManagerServiceProvider',
        'LaravelEnso\Impersonate\ImpersonateServiceProvider',
        'LaravelEnso\Localisation\LocalisationServiceProvider',
        'LaravelEnso\LogManager\LogManagerServiceProvider',
        'LaravelEnso\MenuManager\MenuManagerServiceProvider',
        'LaravelEnso\Notifications\NotificationsServiceProvider',
        'LaravelEnso\PermissionManager\PermissionManagerServiceProvider',
        'LaravelEnso\Select\SelectServiceProvider',
        'LaravelEnso\TutorialManager\TutorialManagerServiceProvider',
    ];

    private $aliases = [
        'Form' => 'Collective\Html\FormFacade',
        'Html' => 'Collective\Html\HtmlFacade',
        'Excel' => 'Maatwebsite\Excel\Facades\Excel',
        'Flash' => 'Laracasts\Flash\Flash',
        'EnsoException' => 'LaravelEnso\Core\app\Exceptions\EnsoException',
    ];

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
            __DIR__ . '/config/laravel-enso.php' => config_path('laravel-enso.php'),
        ], 'core-config');

        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'core-migrations');

        $this->publishes([
            __DIR__ . '/resources/routes/web.php' => base_path('routes/web.php'),
        ], 'core-routes');

        $this->publishes([
            __DIR__ . '/resources/lang' => resource_path('lang'),
        ], 'core-lang');
    }

    private function publishesClasses()
    {
        $this->publishes([
            __DIR__ . '/resources/Classes/DataTable' => app_path('DataTable'),
            __DIR__ . '/resources/Classes/Enums' => app_path('Enums'),
        ], 'core-classes');

        $this->publishes([
            __DIR__ . '/resources/Classes/Controllers' => app_path('Http/Controllers'),
        ], 'core-controllers');

        $this->publishes([
            __DIR__ . '/resources/Classes/Requests' => app_path('Http/Requests'),
        ], 'core-requests');

        $this->publishes([
            __DIR__ . '/resources/Classes/Models' => app_path(),
        ], 'core-models');

        $this->publishes([
            __DIR__ . '/app/Notifications' => app_path('Notifications/vendor/laravel-enso'),
        ], 'core-notification');
    }

    private function publishesViews()
    {
        $this->publishes([
            __DIR__ . '/resources/views/layouts' => resource_path('views/vendor/laravel-enso/core/layouts'),
        ], 'core-layouts-views');

        $this->publishes([
            __DIR__ . '/resources/views/partials' => resource_path('views/vendor/laravel-enso/core/partials'),
        ], 'core-partials-views');

        $this->publishes([
            __DIR__ . '/resources/views/includes' => resource_path('views/vendor/laravel-enso/core/includes'),
        ], 'core-includes-views');

        $this->publishes([
            __DIR__ . '/resources/views/pages' => resource_path('views/vendor/laravel-enso/core/pages'),
        ], 'core-pages-views');

        $this->publishes([
            __DIR__ . '/resources/views/pages/administration' => resource_path('views/vendor/laravel-enso/core/pages/administration'),
        ], 'core-administration-views');

        $this->publishes([
            __DIR__ . '/resources/views/pages/dashboard' => resource_path('views/vendor/laravel-enso/core/pages/dashboard'),
        ], 'core-dashboard-view');

        $this->publishes([
            __DIR__ . '/resources/views/auth' => resource_path('views/auth'),
        ], 'core-auth-views');

        $this->publishes([
            __DIR__ . '/resources/views/errors' => resource_path('views/errors'),
        ], 'core-error-views');
    }

    private function publishesResources()
    {
        $this->publishes([
            __DIR__ . '/resources/storage' => storage_path('app'),
        ], 'core-storage');

        $this->publishes([
            __DIR__ . '/resources/assets/images' => resource_path('assets/images'),
        ], 'core-images');

        $this->publishes([
            __DIR__ . '/resources/assets/js' => resource_path('assets/js/vendor/laravel-enso'),
        ], 'core-js');

        $this->publishes([
            __DIR__ . '/resources/assets/libs' => resource_path('assets/libs'),
        ], 'core-libs');

        $this->publishes([
            __DIR__ . '/resources/assets/main-js' => resource_path('assets/js'),
        ], 'core-main-js');

        $this->publishes([
            __DIR__ . '/resources/assets/sass' => resource_path('assets/sass'),
        ], 'core-sass');

        $this->publishes([
            __DIR__ . '/resources/assets/root' => base_path(),
        ], 'core-root');

        $this->publishes([
            __DIR__ . '/resources/assets/js' => resource_path('assets/js/vendor/laravel-enso'),
            __DIR__ . '/resources/assets/libs' => resource_path('assets/libs'),
            __DIR__ . '/resources/assets/main-js' => resource_path('assets/js'),
            __DIR__ . '/resources/assets/sass' => resource_path('assets/sass'),
        ], 'update');
    }

    private function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('verifyActiveState', VerifyActiveState::class);
        $this->app['router']->aliasMiddleware('action-logger', ActionLogger::class);
        $this->app['router']->aliasMiddleware('impersonate', Impersonate::class);

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
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laravel-enso/core');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    private function registerComposers()
    {
        view()->composer('laravel-enso/core::layouts.app',
            MainComposer::class);

        view()->composer('laravel-enso/menumanager::breadcrumbs',
            BreadcrumbsComposer::class);
    }

    public function register()
    {
        $this->registerProviders();
        $this->registerAliases();
    }

    private function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    private function registerAliases()
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->aliases as $alias => $abstract) {
            $loader->alias($alias, $abstract);
        }
    }
}
