<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PeopleUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasColumn('people', 'bank');
    }

    protected function migrateTable()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('bank')->nullable()->after('birthday');
            $table->string('bank_account')->nullable()->after('bank');
        });
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('bank');
            $table->dropColumn('bank_account');
        });
    }
}
