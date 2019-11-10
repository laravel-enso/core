<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Permissions\app\Models\Permission;

class CountriesUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('countries')
            || Permission::whereName('core.countries.options')->exists();
    }

    protected function migrateTable()
    {
        Permission::whereName('core.addresses.countryOptions')
            ->update(['name' => 'core.countries.options']);

        DB::table('migrations')->insert([
            'migration' => '2017_12_07_150100_create_structure_for_countries',
            'batch' => DB::table('migrations')->max('batch') + 1,
        ]);
    }
}
