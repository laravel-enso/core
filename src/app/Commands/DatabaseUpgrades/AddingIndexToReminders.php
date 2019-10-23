<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddingIndexToReminders extends DatabaseUpgrade
{
    const FOREIGN_KEY = 'calendar_reminders_event_id_foreign';

    protected function isMigrated()
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $doctrineTable = $sm->listTableDetails('calendar_reminders');
        $foreignKey = $doctrineTable->getForeignKeys()[self::FOREIGN_KEY];

        return $foreignKey->getForeignTableName() === 'calendar_events';
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
