<?php

namespace LaravelEnso\Core\app\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddingIndexToEventUsers extends DatabaseUpgrade
{
    const FOREIGN_KEY = 'event_user_event_id_foreign';

    protected function isMigrated()
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $doctrineTable = $sm->listTableDetails('event_user');
        $foreignKey = $doctrineTable->getForeignKeys()[self::FOREIGN_KEY] ?? null;

        return optional($foreignKey)->getForeignTableName() === 'calendar_events';
    }

    protected function migrateTable()
    {
        Schema::table('event_user', function (Blueprint $table) {
            $table->dropForeign(self::FOREIGN_KEY);

            $table->foreign('event_id')->references('id')->on('calendar_events')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
