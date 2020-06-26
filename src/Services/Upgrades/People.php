<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class People implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('people', 'notes');
    }

    public function migrateTable(): void
    {
        Schema::table('people', fn (Blueprint $table) => $table
            ->renameColumn('obs', 'notes'));
    }
}
