<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddingIndexToReminders extends DatabaseUpgrade
{
    const FOREIGN_KEY = 'reminders_event_id_foreign';

    protected function isMigrated()
    {
        $foreignKey = Schema::getConnection()->getDoctrineSchemaManager()
                ->listTableDetails('calendar_reminders')
                ->getForeignKeys()[self::FOREIGN_KEY] ?? null;

        return $foreignKey == null
            || $foreignKey->getForeignTableName() === 'calendar_events';
    }

    protected function migrateTable()
    {
        Schema::table('calendar_reminders', function (Blueprint $table) {
            $table->dropForeign(self::FOREIGN_KEY);

            $table->foreign('event_id')->references('id')->on('calendar_events')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
