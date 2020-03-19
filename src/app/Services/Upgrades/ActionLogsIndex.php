<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;
use LaravelEnso\Upgrade\App\Services\Table;

class ActionLogsIndex implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasIndex('action_logs', 'action_logs_created_at_index');
    }

    public function migrateTable(): void
    {
        Schema::table('action_logs', fn ($table) => $table->index('created_at'));
    }
}
