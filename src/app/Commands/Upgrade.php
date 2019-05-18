<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Roles\app\Enums\Roles;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\Localisation\app\Models\Language;
use LaravelEnso\Permissions\app\Models\Permission;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Core';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        $this->upgradeLanguagesTable()
            ->upgradeMigrationName()
            ->addOrganizeMenus();
    }

    private function upgradeLanguagesTable()
    {
        if (Schema::hasColumn('languages', 'is_rtl')) {
            $this->info('Languages table is already upgraded');

            return $this;
        }

        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('is_rtl')->after('flag')->nullable();
        });

        Language::where('name', '<>', 'ar')->update(['is_rtl' => false]);

        Language::whereName('ar')->update(['is_rtl' => true]);

        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('is_rtl')->nullable(false)->change();
        });

        $this->info('Languages table was successfuly upgraded');

        return $this;
    }

    private function upgradeMigrationName()
    {
        $this->info('Renaming migrations');

        DB::table('migrations')->whereMigration('2017_01_01_144000_create_structure_for_comments_manager')
            ->update(['migration' => '2017_01_01_144000_create_structure_for_comments']);

        DB::table('migrations')->whereMigration('2017_01_01_149750_create_structure_for_how_to_videos')
            ->update(['migration' => '2017_01_01_149750_create_structure_for_how_to']);

        DB::table('migrations')->whereMigration('2017_01_01_134000_create_structure_for_logmanager')
            ->update(['migration' => '2017_01_01_134000_create_structure_for_logs']);

        $this->info('Migrations renamed');

        return $this;
    }

    private function addOrganizeMenus()
    {
        if (Permission::whereName('system.menus.organize')->first() !== null) {
            $this->info('Organize menu was already added');

            return $this;
        }

        $this->info('Adding organize menus');

        $permission = Permission::create([
            'name' => 'system.menus.organize',
            'description' => 'Organize menus',
            'type' => 1,
            'is_default' => false,
        ]);

        $permission->roles()->sync(Roles::keys());

        $this->info('Organize menus was added');

        return $this;
    }
}
