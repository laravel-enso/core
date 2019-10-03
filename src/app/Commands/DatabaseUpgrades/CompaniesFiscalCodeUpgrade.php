<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CompaniesFiscalCodeUpgrade extends DatabaseUpgrade
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
        Schema::table('companies', function (Blueprint $table) {
            $table->unique('reg_com_nr');
            $table->unique('fiscal_code');
        });
    }
}
