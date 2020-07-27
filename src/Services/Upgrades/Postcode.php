<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Postcode as Model;
use LaravelEnso\Upgrade\Contracts\MigratesData;

class Postcode implements MigratesData
{
    public function migrateData(): void
    {
        ini_set('memory_limit', -1);

        Artisan::call('db:seed', [
            '--class' => 'PostcodeSeeder',
            '--force' => true,
        ]);
    }

    public function isMigrated(): bool
    {
        return ! Schema::hasTable('postcodes') || Model::exists();
    }
}
