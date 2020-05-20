<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class RoAddresses implements MigratesTable, MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return false;

        return ! Schema::hasTable('addresses')
            || Schema::hasColumn('addresses', 'region_id');;
    }

    public function migrateTable(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->renameColumn('county_id', 'region_id');
            $table->renameIndex('addresses_county_id_index', 'addresses_region_id_index');
            $table->string('city')->nullable()->after('locality_id');
            $table->string('additional')->nullable()->after('street');
        });
    }

    public function migrateData(): void
    {
        App::setLocale('ro');

        Address::each(function (Address $address) {
            $address->update([
                'street' => $this->street($address),
                'additional' => $this->additional($address),
            ]);
        });

        Permission::whereName('core.addresses.countiesOptions')
            ->update(['name' => 'core.addresses.regionsOptions']);
    }

    public function migratePostDataMigration(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn([
                'sector', 'neighbourhood', 'apartment', 'floor', 'entry',
                'building', 'building_type', 'number', 'street_type',
            ]);
        });
    }

    private function street(Address $address)
    {
        return $this->implode(
            [
                __($address->street_type), $address->street, $address->number,
            ],
            ' ');
    }

    private function additional(Address $address)
    {
        $buildingType = $address->building
            ? __($address->building_type ?? 'Building')
            : null;

        $entryPrefix = $address->entry
            ? __('Entry')
            : null;

        $floorPrefix = $address->floor
            ? __('Floor')
            : null;

        $apartamentPrefix = $address->apartament
            ? __('Apartment')
            : null;

        return $this->implode(
            [
                $this->implode([$buildingType, $address->building], ' '),
                $this->implode([$entryPrefix, $address->entry], ' '),
                $this->implode([$floorPrefix, $address->floor], ' '),
                $this->implode([$apartamentPrefix, $address->apartament], ' '),
            ],
            ', '
        );
    }

    private function implode(array $elements, string $glue)
    {
        return (new Collection($elements))
            ->filter()
            ->implode($glue);
    }
}
