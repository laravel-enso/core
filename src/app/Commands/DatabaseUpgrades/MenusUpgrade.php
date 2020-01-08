<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MenusUpgrade extends DatabaseUpgrade
{
    const FOREIGN_KEY = 'menus_parent_id_name_unique';

    protected function isMigrated()
    {
        return array_key_exists(self::FOREIGN_KEY, Schema::getConnection()
            ->getDoctrineSchemaManager()->listTableIndexes('menus'));
    }

    protected function migrateTable()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->unique(['parent_id', 'name']);
        });
    }
}
