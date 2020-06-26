<?php

namespace LaravelEnso\Core\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class Companies implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('companies', 'website');
    }

    public function migrateTable(): void
    {
        Schema::table('companies', fn (Blueprint $table) => $table
            ->string('website')->nullable()->after('fax'));
    }
}
