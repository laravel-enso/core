<?php

namespace LaravelEnso\Core\app\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;

class Upgrade extends Command
{
    protected $signature = 'enso:upgrade';

    protected $description = 'This command will upgrade Enso for 2.13.0';

    public function handle()
    {
        $this->info('The upgrade process has started');
        $this->upgrade();
        $this->info('The upgrade process was successful.');
    }

    private function upgrade()
    {
        \DB::transaction(function () {
            $this->renameTableRoutes();
            $this->updateMenuStructure();
            $this->updatePermissionStructure();
            $this->updateCoreHome();
        });
    }

    private function renameTableRoutes()
    {
        $this->info('Renaming vue datatable routes');

        Permission::where('name', 'LIKE', '%getTableData')
            ->get()
            ->each(function ($permission) {
                $permission->update([
                    'name' => Str::replaceFirst(
                        'getTableData', 'tableData', $permission->name
                    ),
                ]);
            });

        $this->info('Renaming was successfully performed');

        return $this;
    }

    private function updateMenuStructure()
    {
        if (Schema::hasColumn('menus', 'permission_id')) {
            $this->info('The menu structure was already upgraded');

            return $this;
        }

        $this->info('Upgrading the menu structure');

        Schema::table('menus', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned()->index()
                ->after('parent_id')
                ->nullable();
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        Menu::all()->each(function ($menu) {
            if (! is_null($menu->link)) {
                $menu->update([
                    'permission_id' => Permission::whereName($menu->link)->first()->id,
                ]);
            }
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('link');
        });

        Schema::dropIfExists('menu_role');

        $this->info('The menu structure was successfully upgraded');

        return $this;
    }

    private function updatePermissionStructure()
    {
        $this->info('Upgrading the permissions structure');

        if (! Schema::hasColumn('permissions', 'permission_group_id')) {
            $this->info('The permissions structure was already upgraded');

            return $this;
        }

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_group_id']);
            $table->dropColumn('permission_group_id');
        });

        Schema::dropIfExists('permission_groups');

        Menu::whereName('Permission Groups')->delete();

        Permission::where('name', 'LIKE', 'permissionGroups.%')
            ->orWhere('name', 'LIKE', 'system.resourcePermissions.%')
            ->delete();

        $this->info('The permissions structure was successfully upgraded');

        return $this;
    }

    private function updateCoreHome()
    {
        Permission::whereName('core.index')->update(['name' => 'core.home.index']);
    }
}
