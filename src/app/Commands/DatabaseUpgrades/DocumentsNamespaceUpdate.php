<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DocumentsNamespaceUpdate extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('documents')
            || ! Schema::hasColumn('documents', 'documentable_type');
    }

    protected function migrateTable()
    {
        DB::statement("UPDATE documents SET documentable_type=REPLACE(documentable_type, '\app\\\', '\App\\\')");
    }
}
