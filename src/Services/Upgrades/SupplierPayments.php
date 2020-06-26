<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Financials\Models\Suppliers\Payment;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class SupplierPayments implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! Payment::exists()
            || Schema::hasColumn('supplier_payments', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('supplier_payments', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
