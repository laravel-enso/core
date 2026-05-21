<?php

namespace LaravelEnso\Core;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use LaravelEnso\Core\Commands\AnnounceAppUpdate;
use LaravelEnso\Core\Commands\ResetPreferences;
use LaravelEnso\Core\Commands\ResetStorage;
use LaravelEnso\Core\Commands\UpdateGlobalPreferences;
use LaravelEnso\Core\Commands\Version;
use LaravelEnso\Core\Services\Websockets;
use LaravelEnso\Helpers\Services\Dummy;
use LaravelEnso\Helpers\Services\FactoryResolver;
use LaravelEnso\Mails\Preview\PreviewDefinition;
use LaravelEnso\Mails\Preview\PreviewRegistry;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        'websockets' => Websockets::class,
    ];

    public function boot(): void
    {
        JsonResource::withoutWrapping();

        $this->loadDependencies()
            ->publishDependencies()
            ->publishResources()
            ->registerPreviews()
            ->setFactoryResolver()
            ->commands(
                AnnounceAppUpdate::class,
                ResetPreferences::class,
                ResetStorage::class,
                UpdateGlobalPreferences::class,
                Version::class,
            );
    }

    private function loadDependencies(): self
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

    private function publishDependencies(): self
    {
        $this->publishes([
            __DIR__.'/../config' => $this->app->configPath('enso'),
        ], ['core-config', 'enso-config']);

        $this->publishes([
            __DIR__.'/../database/seeders' => $this->app->databasePath('seeders'),
        ], ['core-seeders', 'enso-seeders']);

        return $this;
    }

    private function publishResources(): self
    {
        $this->publishes([
            __DIR__.'/../resources/images' => $this->app->resourcePath('images'),
        ], ['core-assets', 'enso-assets']);

        return $this;
    }

    private function registerPreviews(): self
    {
        $registry = $this->app->make(PreviewRegistry::class);

        $registry->register(new PreviewDefinition(
            key: 'password-reset',
            name: 'Password Reset',
            view: 'laravel-enso/core::emails.reset',
            data: [
                'name' => 'Jane',
                'url' => 'https://example.com/password/reset/token',
            ],
            section: PreviewDefinition::Core,
        ));

        $registry->register(new PreviewDefinition(
            key: 'password-set',
            name: 'Password Set',
            view: 'laravel-enso/core::emails.set',
            data: [
                'name' => 'Jane',
                'url' => 'https://example.com/password/reset/token',
            ],
            section: PreviewDefinition::Core,
        ));

        return $this;
    }

    private function setFactoryResolver(): self
    {
        Factory::guessFactoryNamesUsing(new FactoryResolver());

        if (! class_exists('\Faker\Generator')) {
            App::bind(\Faker\Generator::class, Dummy::class);
        }

        return $this;
    }
}
