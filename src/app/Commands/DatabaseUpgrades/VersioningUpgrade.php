<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VersioningUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return DB::table('migrations')
            ->whereMigration('2018_05_01_100000_create_versionings_table')
            ->doesntExist();
    }

    public function migrateTable()
    {
        DB::table('migrations')->whereMigration('2018_05_01_100000_create_versionings_table')
            ->update(['migration' => '2017_01_01_009000_create_versionings_table']);

        Schema::table('versionings', function ($table) {
            $table->dropIndex(['versionable_type', 'versionable_id']);
        });

        Schema::table('versionings', function ($table) {
            $table->unique(['versionable_type', 'versionable_id']);
        });
    }
}
