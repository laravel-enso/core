<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Support\Facades\Artisan;
use LaravelEnso\ControlPanelApi\AppServiceProvider;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class ControlPanel implements MigratesData
{
    private const email = 'monitoring@laravel-enso.com';

    public function migrateData(): void
    {
        Artisan::call('db:seed --class=ControlPanelApiSeeder');
    }

    public function isMigrated(): bool
    {
        return ! class_exists(AppServiceProvider::class)
            || User::whereEmail(static::email)->exists();
    }
}
