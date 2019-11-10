<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CalendarUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('calendar_events')
            || Schema::hasColumn('calendar_events', 'frequency');
    }

    protected function migrateTable()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->renameColumn('frequence', 'frequency');
            $table->dropColumn('is_readonly');
        });
    }
}
