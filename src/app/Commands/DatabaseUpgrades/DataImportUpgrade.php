<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\DataImport\app\Models\DataImport;

class DataImportUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasColumn('data_imports', 'chunks');
    }

    protected function migrateTable()
    {
        Schema::table('data_imports', function (Blueprint $table) {
            $table->integer('chunks')->after('failed')->nullable();
            $table->integer('processed_chunks')->after('chunks')->nullable();
            $table->boolean('file_parsed')->after('processed_chunks')->nullable();
        });
    }

    protected function postMigrateTable()
    {
        DataImport::query()
            ->update([
                'chunks' => 1,
                'processed_chunks' => 1,
                'file_parsed' => true,
            ]);

        Schema::table('data_imports', function (Blueprint $table) {
            $table->integer('chunks')->nullable(false)->change();
            $table->integer('processed_chunks')->nullable(false)->change();
            $table->boolean('file_parsed')->nullable(false)->change();
        });

        Artisan::call('vendor:publish --tag=data-import-factory');
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('data_imports', function (Blueprint $table) {
            $table->dropColumn(['chunks', 'processed_chunks', 'file_parsed']);
        });
    }
}
