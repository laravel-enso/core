<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Versioning\app\Models\Versioning;

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
