<?php

use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultOwner extends Migration
{
    public function up()
    {
        \DB::transaction(function () {
            $owners = [
                ['name' => 'Admin', 'is_active' => true],
            ];

            $roles = Role::all();

            foreach ($owners as $owner) {
                $owner = new Owner($owner);
                $owner->save();
                $owner->roles()->attach($roles);
            }
        });
    }

    public function down()
    {
        \DB::table('owners')->delete();
    }
}
