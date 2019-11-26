<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DocumentsUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('documents')
            || Schema::hasColumn('documents', 'text');
    }

    protected function migrateTable()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->longText('text')->nullable()->after('documentable_id');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE `documents` ADD FULLTEXT(`text`)');
        }
    }
}
