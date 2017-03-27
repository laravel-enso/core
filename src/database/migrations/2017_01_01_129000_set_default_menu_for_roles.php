<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\app\Models\Menu;
use LaravelEnso\Core\app\Models\Role;

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
        //
    }
}
