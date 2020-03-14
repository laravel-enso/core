<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;

class Permissions extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasColumn('permissions', 'type');
    }

    protected function migrateTable()
    {
        Schema::table('permissions', fn ($table) => $table->dropColumn('type'));
    }
}
