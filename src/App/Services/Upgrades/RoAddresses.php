<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\App\Models\Locality;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class RoAddresses extends AddressMigrator implements MigratesTable, MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return ! Locality::exists()
            || Schema::hasColumn('addresses', 'region_id');
    }

    public function migrateTable(): void
    {
        parent::migrateTable();

        Schema::table('addresses', function (Blueprint $table) {
            $table->renameColumn('county_id', 'region_id');
            $table->renameIndex('addresses_county_id_index', 'addresses_region_id_index');
        });
    }

    public function migrateData(): void
    {
        App::setLocale('ro');

        parent::migrateData();
    }

    public function migratePostDataMigration(): void
    {
        parent::migratePostDataMigration();

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'sector', 'neighbourhood',
            ]);
        });
    }
}
