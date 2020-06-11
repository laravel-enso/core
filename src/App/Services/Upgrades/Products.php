<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Products implements MigratesTable
{
    public function isMigrated(): bool
    {
        return ! Schema::hasTable('products')
            || Schema::hasColumn('products', 'html_description');
    }

    public function migrateTable(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('html_description')->nullable()
                ->after('description');
        });
    }
}
