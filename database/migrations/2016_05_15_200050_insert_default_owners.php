<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Models\Menu;
use LaravelEnso\Core\Models\Owner;
use LaravelEnso\Core\Models\Role;

class InsertDefaultOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $owners = [
            ['name' => 'Admin', 'fiscal_code' => null, 'reg_com_nr' => null, 'city' => null, 'county' => null, 'address' => null, 'postal_code' => null, 'bank' => null, 'bank_account' => null, 'contact' => null, 'phone' => null, 'email' => null, 'is_active' => 1],
        ];

        $menus = Menu::all();
        $roles = Role::all();

        \DB::transaction(function () {
            foreach ($owners as $owner) {
                $owner = new Owner($owner);
                $owner->save();
                $owner->attach($roles);
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
        \DB::table('users')->delete();
    }
}
