<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Support\Facades\Artisan;
use LaravelEnso\Addresses\Models\Postcode as Model;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class Postcode implements MigratesData
{
    public function migrateData(): void
    {
        ini_set('memory_limit', -1);

        Artisan::call('db:seed', [
            '--class' => 'PostcodeSeeder',
        ]);
    }

    public function isMigrated(): bool
    {
        return Model::exists();
    }
}
