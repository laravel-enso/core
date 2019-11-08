<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompaniesIndexesUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableDetails('companies')
            ->hasIndex('companies_fiscal_code_unique');
    }

    public function migrateTable()
    {
        if (Schema::hasColumn('companies', 'reg_com_nr')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->unique('reg_com_nr');
            });
        }

        if (Schema::hasColumn('companies', 'fiscal_code')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->unique('fiscal_code');
            });
        }
    }
}
