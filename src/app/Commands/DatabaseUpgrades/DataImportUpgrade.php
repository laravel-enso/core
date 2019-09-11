<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class DataImportUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableDetails('data_imports')
            ->hasIndex('data_imports_type_index');
    }

    protected function migrateTable()
    {
        Schema::table('data_imports', function (Blueprint $table) {
            $table->index('type');
        });

        Schema::table('import_templates', function (Blueprint $table) {
            $table->index('type');
        });
    }

    protected function rollbackMigrateTable()
    {
        //
    }
}
