<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Addresses\App\Models\Locality;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

// RUN UPGRADE BEFORE MIGRATIONS
class RoAddresses implements MigratesTable, MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return ! Locality::exists()
            || Schema::hasColumn('addresses', 'region_id');
    }

    public function migrateTable(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('city')->nullable()->after('locality_id');
            $table->string('additional')->nullable()->after('street');
            $table->renameIndex('addresses_county_id_index', 'addresses_region_id_index');
            $table->renameColumn('county_id', 'region_id');
            $table->renameColumn('obs', 'notes');
            $table->renameColumn('postal_area', 'postcode');
        });
    }

    public function migrateData(): void
    {
        App::setLocale('ro');

        Address::each(function (Address $address) {
            $address->update([
                'street' => Str::ucfirst($this->street($address)),
                'additional' => Str::ucfirst($this->additional($address)),
            ]);
        });

        Permission::whereName('commercial.sales.addresses',)
            ->update(['name' => 'core.addresses.options']);
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
            ? __($address->building_type ?? 'bloc')
            : null;

        $entryPrefix = $address->entry
            ? 'scara'
            : null;

        $floorPrefix = $address->floor
            ? 'etaj'
            : null;

        $apartamentPrefix = $address->apartament
            ? 'ap.'
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
