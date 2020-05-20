<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Localities implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('localities', 'region_id');
    }

    public function migrateTable(): void
    {
        Schema::table('localities', function (Blueprint $table) {
            $table->renameColumn('county_id', 'region_id');
            $table->renameIndex('localities_county_id_index', 'localities_region_id_index');
        });
    }
}
