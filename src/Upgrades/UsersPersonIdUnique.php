<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class UsersPersonIdUnique implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasIndex('users', 'users_person_id_unique');
    }

    public function migrateTable(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table
            ->unique(['person_id']));
    }
}
