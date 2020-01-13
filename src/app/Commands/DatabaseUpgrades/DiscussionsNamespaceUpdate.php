<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiscussionsNamespaceUpdate extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('discussions')
            || ! Schema::hasColumn('discussions', 'discussable_type');
    }

    protected function migrateTable()
    {
        DB::statement("UPDATE discussions SET discussable_type=REPLACE(discussable_type, '\app\\\', '\App\\\')");
    }
}
