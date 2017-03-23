<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Models\Menu;
use LaravelEnso\Core\Models\Role;

class InsertDefaultRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = [
            [ 'menu_id' => 1, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Administrator role. Full featured.' ],
            [ 'menu_id' => 1, 'name' => 'supervisor', 'display_name' => 'Supervisor', 'description' => 'Supervisor role. Full featured.' ],
        ];

        $menus = Menu::all();

        \DB::transaction(function () {
            foreach ($roles as $role) {
                $role = new Role($role);
                $role->save();
                $role->attach($menus);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('roles')->delete();
    }
}
