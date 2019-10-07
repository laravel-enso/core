<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class SupplierProductPivotUpgrade extends DatabaseUpgrade
{
    protected $title = 'adding acquisition_price to product_supplier';

    protected function isMigrated()
    {
        return ! Schema::hasTable('product_supplier')
            || Schema::hasColumn('product_supplier', 'part_number');
    }

    protected function migrateTable()
    {
        Schema::table('product_supplier', function (Blueprint $table) {
            $table->string('part_number')->after('acquisition_price')
                ->unsigned()->nullable();
            $table->timestamps();
        });
    }

    protected function migrateData()
    {
        //
    }

    protected function postMigrateTable()
    {
        //
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('product_supplier', function (Blueprint $table) {
            $table->dropColumn(['acquisition_price', 'created_at', 'updated_at']);
        });
    }
}
