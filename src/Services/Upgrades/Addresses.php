<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Addresses implements MigratesTable
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
}
