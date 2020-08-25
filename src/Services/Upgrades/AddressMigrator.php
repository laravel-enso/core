<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Permissions\Models\Permission;

class AddressMigrator
{
    public function migrateTable(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('city')->nullable()->after('locality_id');
            $table->string('additional')->nullable()->after('street');
        });
    }

    public function migrateData(): void
    {
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
                'apartment', 'floor', 'entry',
                'building', 'building_type', 'number', 'street_type',
            ]);
        });
    }

    protected function street(Address $address)
    {
        return $this->implode(
            [
                __($address->street_type), $address->street, $address->number,
            ],
            ' '
        );
    }

    protected function additional(Address $address)
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

    protected function implode(array $elements, string $glue)
    {
        return (new Collection($elements))
            ->filter()
            ->implode($glue);
    }
}
