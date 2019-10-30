<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CalendarEventUpgrade extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return Schema::hasColumn('calendar_events', 'starts_date');
    }

    public function migrateTable()
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropColumn('starts_at');
            $table->dropColumn('ends_at');

            $table->date('starts_date')->index()->default('2000-01-01')->after('frequence');
            $table->date('ends_date')->index()->default('2000-01-01')->after('starts_date');
            $table->time('starts_time')->after('ends_date');
            $table->time('ends_time')->after('starts_time');
        });

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->date('starts_date')->default(null)->change();
            $table->date('ends_date')->default(null)->change();
        });
    }
}
