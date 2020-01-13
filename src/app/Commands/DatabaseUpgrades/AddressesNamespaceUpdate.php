<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddressesNamespaceUpdate extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('addresses')
            || ! Schema::hasColumn('addresses', 'addressable_type');
    }

    protected function migrateTable()
    {
        DB::statement("UPDATE addresses SET addressable_type=REPLACE(addressable_type, '\app\\\', '\App\\\')");
    }
}
