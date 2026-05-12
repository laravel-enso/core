<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class LoginCreatedAtIndex implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasTable('logins')
            && Schema::hasIndex('logins', 'logins_created_at_index');
    }

    public function migrateTable(): void
    {
        if ($this->isMigrated()) {
            return;
        }

        Schema::table('logins', fn (Blueprint $table) => $table->index('created_at'));
    }
}
