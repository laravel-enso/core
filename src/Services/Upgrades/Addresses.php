<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Upgrade\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Addresses implements MigratesTable, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('addresses', 'is_billing');
    }

    public function migrateTable(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('is_billing')->after('is_default');
            $table->boolean('is_shipping')->after('is_billing');
        });
    }

    public function migratePostDataMigration(): void
    {
        Address::whereIsDefault(true)
            ->update([
                'is_billing' => true,
                'is_shipping' => true,
            ]);
    }
}
