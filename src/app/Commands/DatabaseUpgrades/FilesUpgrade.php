<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->index('original_name');
        });
    }

    protected function rollbackMigrateTable()
    {
        //
    }
}
