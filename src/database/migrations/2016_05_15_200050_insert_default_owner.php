<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Core\app\Models\Role;

class InsertDefaultOwner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('owners')->delete();
    }
}
