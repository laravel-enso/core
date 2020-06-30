<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Financials\Models\Clients\Invoice;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class ClientInvoices implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! Invoice::exists()
            || Schema::hasColumn('client_invoices', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('client_invoices', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
