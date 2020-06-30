<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Financials\Models\Suppliers\Invoice;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class SupplierInvoices implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! Invoice::exists()
            || Schema::hasColumn('supplier_invoices', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('supplier_invoices', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
