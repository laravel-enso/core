<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Models\Permission;
use LaravelEnso\Core\Models\PermissionsGroup;
use LaravelEnso\Core\Models\Role;

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

        $roles->each(function($role) {
            $role->menu_id = 1;
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
