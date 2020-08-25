<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Companies implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('companies', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('companies', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
