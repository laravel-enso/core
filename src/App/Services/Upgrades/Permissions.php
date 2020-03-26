<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Permissions implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! Schema::hasColumn('permissions', 'type');
    }

    public function migrateTable(): void
    {
        Schema::table('permissions', fn ($table) => $table->dropColumn('type'));
    }
}
