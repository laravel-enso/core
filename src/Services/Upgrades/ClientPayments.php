<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Financials\AppServiceProvider;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class ClientPayments implements MigratesTable
{
    public function isMigrated(): bool
    {
        return  ! class_exists(AppServiceProvider::class)
            || Schema::hasColumn('client_payments', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('client_payments', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
