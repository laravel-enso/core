<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\app\Models\Role;
use LaravelEnso\MenuManager\app\Models\Menu;

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
        $menu = Menu::whereHasChildren(false)->first();

        $roles->each(function ($role) use ($menu) {
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
        $roles = Role::all();

        $roles->each(function ($role) {
            $role->menu_id = null;
            $role->save();
        });
    }
}
