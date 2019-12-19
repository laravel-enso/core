<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CurrenciesUpgrade extends DatabaseUpgrade
{

    protected function isMigrated()
    {
        return ! Schema::hasTable('currencies')
            || Schema::hasColumn('currencies', 'code');
    }

    protected function migrateTable()
    {
        Schema::table('currencies', fn (Blueprint $table) => (
            $table->renameColumn('short_name', 'code')
        ));
    }
}
