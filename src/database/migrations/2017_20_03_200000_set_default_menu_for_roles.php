<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\App\Models\Menu;
use LaravelEnso\Core\App\Models\Permission;
use LaravelEnso\Core\App\Models\PermissionsGroup;
use LaravelEnso\Core\App\Models\Role;

class SetDefaultMenuForRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = Role::all();
        $menu = Menu::where('parent_id', null)->first();

        $roles->each(function($role) use ($menu) {
            $role->menu_id = $menu->id;
            $role->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
