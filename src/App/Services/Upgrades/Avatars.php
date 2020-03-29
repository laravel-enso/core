<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;
use LaravelEnso\Upgrade\App\Helpers\Table;

class Avatars implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasIndex('avatars', 'avatars_user_id_unique');
    }

    public function migrateTable(): void
    {
        Schema::table('avatars', fn ($table) => $table->unique('user_id'));
    }
}
