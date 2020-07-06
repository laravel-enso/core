<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Financials\AppServiceProvider;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class SupplierInvoices implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! class_exists(AppServiceProvider::class)
            || Schema::hasColumn('supplier_invoices', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('supplier_invoices', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
