<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class DataImport implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('data_imports', 'params');
    }

    public function migrateTable(): void
    {
        Schema::table('data_imports', function (Blueprint $table) {
            $table->json('params')->nullable()->after('status');
        });
    }
}
