<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Countries\App\Models\Country;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;
use LaravelEnso\Upgrade\App\Contracts\MigratesPostDataMigration;
use LaravelEnso\Upgrade\App\Contracts\MigratesTable;

class Counties implements MigratesTable, MigratesData, MigratesPostDataMigration
{
    public function isMigrated(): bool
    {
        return ! Schema::hasTable('counties');
    }

    public function migrateTable(): void
    {
        Schema::rename('counties', 'regions');
        Schema::table('regions', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->index()->nullable()->after('id');
            $table->foreign('country_id')->references('id')->on('countries')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->unique(['country_id', 'abbreviation']);
        });
    }

    public function migrateData(): void
    {
        $romania = Country::whereName('Romania')->first();

        DB::table('regions')
            ->update(['country_id' => $romania->id]);
    }

    public function migratePostDataMigration(): void
    {
        Schema::table('regions', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->nullable('false')->change();
        });

        DB::table('migrations')
            ->whereIn('migration', [
                '2017_12_11_102000_alter_addresses_table',
                '2019_06_27_104000_create_structure_for_counties',
                '2017_12_11_103000_create_structure_for_localities',
            ])->delete();

        DB::table('migrations')
            ->whereMigration('2017_12_11_100000_create_counties_table')
            ->update(['migration' => '2017_12_07_150500_create_regions_table']);

        Permission::whereName('core.addresses.countiesOptions')
            ->update(['name' => 'core.addresses.regions']);
    }
}
