<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;

class ActionLogsIndex extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return $this->indexExists('action_logs_created_at_index', 'action_logs');
    }

    protected function migrateTable()
    {
        Schema::table('action_logs', fn ($table) => $table->index('created_at'));
    }
}
