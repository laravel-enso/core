<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\Artisan;
use LaravelEnso\Addresses\App\Models\Locality;
use LaravelEnso\Addresses\App\Models\Region;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class AddressDataSeeds implements MigratesData
{
    public function isMigrated(): bool
    {
        return Region::whereAbbreviation('AB')->exists()
            && Region::whereAbbreviation('AL')->exists()
            && Locality::exists();
    }

    public function migrateData(): void
    {
        if (! Region::whereAbbreviation('AB')->exists()) {
            Artisan::call('db:seed --class=RegionSeeder --force');
        }

        if (! Region::whereAbbreviation('AL')->exists()) {
            Artisan::call('db:seed --class=StateSeeder --force');
        }

        if (! Locality::exists()) {
            Artisan::call('db:seed --class=LocalitySeeder --force');
        }
    }
}
