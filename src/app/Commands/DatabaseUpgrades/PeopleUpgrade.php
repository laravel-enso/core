<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PeopleUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasColumn('people', 'reg_com_nr');
    }

    protected function migrateTable()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('reg_com_nr')->nullable()->after('name');
            $table->string('bank')->nullable()->after('birthday');
            $table->string('bank_account')->nullable()->after('birthday');
        });
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('reg_com_nr');
            $table->dropColumn('bank');
            $table->dropColumn('bank_account');
        });
    }
}
