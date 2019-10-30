<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;

class RenameReminders extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasTable('calendar_reminders');
    }

    public function migrateTable()
    {
        Schema::rename('reminders', 'calendar_reminders');
    }
}
