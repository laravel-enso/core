<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\RoAddresses\App\Models\Locality;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Localities implements MigratesTable, MigratesData
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('localities', 'region_id');
    }

    public function migrateTable(): void
    {
        Schema::table('localities', function (Blueprint $table) {
            $table->renameColumn('county_id', 'region_id');
            $table->renameIndex('localities_county_id_index', 'localities_region_id_index');
        });
    }

    public function migrateData(): void
    {
        DB::table('migrations')
            ->whereMigration('2017_12_11_101000_create_localities_table')
            ->update(['migration' => '2017_12_07_150700_create_localities_table']);

        Permission::whereName('core.addresses.localitiesOptions')
            ->update(['name' => 'core.addresses.localities']);

        if (! Locality::exists()) {
            Artisan::call('db:seed --class=LocalitySeeder --force');
        }
    }
}
