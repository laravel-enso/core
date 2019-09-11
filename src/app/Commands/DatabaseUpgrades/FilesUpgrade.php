<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FilesUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableDetails('files')
            ->hasIndex('files_original_name_index');
    }

    protected function migrateTable()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->index('files_original_name_index');
        });
    }

    protected function rollbackMigrateTable()
    {
        //
    }
}
