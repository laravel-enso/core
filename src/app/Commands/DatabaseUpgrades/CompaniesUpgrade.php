<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\Companies\app\Models\Company;
use LaravelEnso\Companies\app\Enums\CompanyStatuses;

class CompaniesUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasColumn('companies', 'reg_com_nr');
    }

    protected function migrateTable()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('reg_com_nr')->nullable()->after('name');
            $table->string('fiscal_code')->nullable()->after('name');
            $table->tinyInteger('status')->nullable()->after('pays_vat');
        });

        Company::update(['status' => CompanyStatuses::Active]);

        Schema::table('companies', function (Blueprint $table) {
            $table->tinyInteger('status')->nullable(false)->change();
        });
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('reg_com_nr');
            $table->dropColumn('fiscal_code');
            $table->dropColumn('status');
        });
    }
}
