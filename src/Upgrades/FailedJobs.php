<?php

namespace LaravelEnso\Core\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;

class FailedJobs implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Schema::hasColumn('failed_jobs', 'uuid');
    }

    public function migrateTable(): void
    {
        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->string('uuid')->after('id')->nullable()->unique();
        });
    }
}
