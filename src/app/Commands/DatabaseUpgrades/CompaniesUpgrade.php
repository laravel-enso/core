<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Companies\app\Enums\CompanyStatuses;
use LaravelEnso\Companies\app\Models\Company;

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
            $table->boolean('status')->nullable()->after('pays_vat');
        });

        Company::each(function ($company) {
            $company->update(['status' => CompanyStatuses::Active]);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('status')->nullable(false)->change();
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
