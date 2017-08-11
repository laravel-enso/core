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
        'LaravelEnso\Core\AuthServiceProvider',
        'LaravelEnso\Core\EventServiceProvider',
        'LaravelEnso\ActionLogger\ActionLoggerServiceProvider',
        'LaravelEnso\AvatarManager\AvatarServiceProvider',
        'LaravelEnso\Charts\ChartsServiceProvider',
        'LaravelEnso\DataTable\DataTableServiceProvider',
        'LaravelEnso\DbSyncMigrations\DbSyncServiceProvider',
        'LaravelEnso\FileManager\FileManagerServiceProvider',
        'LaravelEnso\FormBuilder\FormBuilderServiceProvider',
        'LaravelEnso\ImageTransformer\ImageTransformerServiceProvider',
        'LaravelEnso\Impersonate\ImpersonateServiceProvider',
        'LaravelEnso\Localisation\LocalisationServiceProvider',
        'LaravelEnso\LogManager\LogsServiceProvider',
        'LaravelEnso\MenuManager\MenusServiceProvider',
        'LaravelEnso\PermissionManager\PermissionsServiceProvider',
        'LaravelEnso\RoleManager\RolesServiceProvider',
        'LaravelEnso\Select\SelectServiceProvider',
        'LaravelEnso\TutorialManager\TutorialsServiceProvider',
        'LaravelEnso\VueAdminLTE\VueAdminLTEServiceProvider',
        'LaravelEnso\VueComponents\VueComponentsServiceProvider',
    ];

    private $aliases = [
        'Form'          => 'Collective\Html\FormFacade',
        'Html'          => 'Collective\Html\HtmlFacade',
        'Excel'         => 'Maatwebsite\Excel\Facades\Excel',
        'Flash'         => 'Laracasts\Flash\Flash',
        'EnsoException' => 'LaravelEnso\Core\app\Exceptions\EnsoException',
    ];

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
            __DIR__.'/resources/assets/js/modules' => resource_path('assets/js/vendor/laravel-enso/modules'),
            __DIR__.'/resources/assets/js/enso.js' => resource_path('assets/js/enso.js'),
        ], 'core-js');

        $this->publishes([
            __DIR__.'/resources/assets/sass' => resource_path('assets/sass'),
        ], 'core-sass');

        $this->publishes([
            __DIR__.'/resources/assets/js/modules' => resource_path('assets/js/vendor/laravel-enso/modules'),
            __DIR__.'/resources/assets/sass'       => resource_path('assets/sass'),
            __DIR__.'/resources/assets/js/enso.js' => resource_path('assets/js/enso.js'),
        ], 'enso-update');
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
