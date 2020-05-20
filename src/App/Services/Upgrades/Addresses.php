<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Addresses extends AddressMigrator implements MigratesTable, MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('addresses', 'region_id');
    }

    public function migrateTable(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->integer('region_id')->unsigned()->index()->nullable()->after('country_id');
            $table->foreign('region_id')->references('id')->on('regions');

            $table->integer('locality_id')->unsigned()->index()->nullable()->after('region_id');
            $table->foreign('locality_id')->references('id')->on('localities');
        });

        parent::migrateTable();
    }

    public function migratePostDataMigration(): void
    {
        parent::migratePostDataMigration();

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'sub_administrative_area', 'administrative_area',
            ]);
        });
    }

    protected function additional(Address $address)
    {
        return $this->implode(
            [
                parent::additional($address),
                $address->administrative_area,
                $address->sub_administrative_area,
            ],
            ', '
        );
    }
}
