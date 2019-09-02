<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Exception;
use App\Enums\VatValues;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\Helpers\app\Classes\Decimals;
use LaravelEnso\Financials\app\Models\Clients\InvoiceLine;

class InvoiceLineUpgrade extends DatabaseUpgrade
{
    protected $title = 'adding vat_percent to invoice_lines';

    protected function isMigrated()
    {
        return ! Schema::hasTable('invoice_lines')
            || Schema::hasColumn('invoice_lines', 'vat_percent');
    }

    protected function migrateTable()
    {
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->integer('vat_percent')->after('vat')->nullable();
        });
    }

    protected function migrateData()
    {
        InvoiceLine::get()
            ->each(function ($invoiceLine) {
                $invoiceLine->vat_percent = round(Decimals::div($invoiceLine->vat, $invoiceLine->amount, 3) * 100);

                if (! VatValues::keys()->contains($invoiceLine->vat_percent)) {
                    throw new Exception('invoice_line #'.$invoiceLine->id.
                        ' has not a acceptable vat_percent('.$invoiceLine->vat_percent.')');
                }

                $invoiceLine->save();
            });
    }

    protected function postMigrateTable()
    {
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->integer('vat_percent')->nullable(false)->change();
        });
    }

    protected function rollbackMigrateTable()
    {
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->dropColumn('vat_percent');
        });
    }
}
