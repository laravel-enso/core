<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FilesNamespaceUpdate extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('files')
            || ! Schema::hasColumn('files', 'attachable_type');
    }

    protected function migrateTable()
    {
        DB::statement("UPDATE files SET attachable_type=REPLACE(attachable_type, '\app\\\', '\App\\\')");
    }
}
