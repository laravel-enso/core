<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddingCalendarToEvents extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasColumn('calendar_events', 'calendar_id');
    }

    protected function migrateTable()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropColumn('calendar');
            $table->integer('calendar_id')->unsigned()->index()
                ->foreign('calendar_id')->references('id')->on('calendars')
                ->onDelete('cascade')->after('id');
        });
    }
}
