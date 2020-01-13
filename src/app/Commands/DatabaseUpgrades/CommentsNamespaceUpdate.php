<?php

namespace LaravelEnso\Core\App\Commands\DatabaseUpgrades;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CommentsNamespaceUpdate extends DatabaseUpgrade
{
    protected function isMigrated()
    {
        return ! Schema::hasTable('comments')
            || ! Schema::hasColumn('comments', 'commentable_type');
    }

    protected function migrateTable()
    {
        DB::statement("UPDATE comments SET commentable_type=REPLACE(commentable_type, '\app\\\', '\App\\\')");
    }
}
