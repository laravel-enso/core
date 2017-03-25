<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\App\Models\Owner;
use LaravelEnso\Core\App\Models\Role;

class InsertDefaultOwners extends Migration
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
                ['name' => 'Admin', 'fiscal_code' => null, 'reg_com_nr' => null, 'city' => null, 'county' => null, 'address' => null, 'postal_code' => null, 'bank' => null, 'bank_account' => null, 'contact' => null, 'phone' => null, 'email' => null, 'is_active' => 1],
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
