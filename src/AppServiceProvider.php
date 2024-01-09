<?php

namespace LaravelEnso\Core;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\Commands\AnnounceAppUpdate;
use LaravelEnso\Core\Commands\ClearPreferences;
use LaravelEnso\Core\Commands\ResetStorage;
use LaravelEnso\Core\Commands\UpdateGlobalPreferences;
use LaravelEnso\Core\Commands\Version;
use LaravelEnso\Core\Services\Websockets;
use LaravelEnso\Helpers\Services\Dummy;
use LaravelEnso\Helpers\Services\FactoryResolver;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        'websockets' => Websockets::class,
    ];

    public function boot()
    {
        JsonResource::withoutWrapping();

        $this->loadDependencies()
            ->publishDependencies()
            ->publishResources()
            ->setFactoryResolver()
            ->commands(
                AnnounceAppUpdate::class,
                ClearPreferences::class,
                ResetStorage::class,
                UpdateGlobalPreferences::class,
                Version::class,
            );
    }

    private function loadDependencies()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/inspiring.php', 'enso.inspiring');

        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'enso.config');

        $this->mergeConfigFrom(__DIR__.'/../config/auth.php', 'enso.auth');

        $this->mergeConfigFrom(__DIR__.'/../config/state.php', 'enso.state');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-enso/core');

        return $this;
    }

    private function publishDependencies()
    {
        $this->publishes([
            __DIR__.'/../config' => config_path('enso'),
        ], ['core-config', 'enso-config']);

        $this->publishes([
            __DIR__.'/../resources/preferences.json' => resource_path('preferences.json'),
        ], ['core-preferences', 'enso-preferences']);

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], ['core-seeders', 'enso-seeders']);

        return $this;
    }

    private function publishResources()
    {
        $this->publishes([
            __DIR__.'/../resources/images' => resource_path('images'),
        ], ['core-assets', 'enso-assets']);

        $this->publishes([
            __DIR__.'/../resources/views/mail' => resource_path('views/vendor/mail'),
        ], ['core-email', 'enso-email']);

        return $this;
    }

    private function setFactoryResolver()
    {
        Factory::guessFactoryNamesUsing(new FactoryResolver());

        if (!class_exists('\Faker\Generator')) {
            App::bind(\Faker\Generator::class, Dummy::class);
        }

        return $this;
    }
}
