<?php

use Illuminate\Database\Migrations\Migration;
use LaravelEnso\Core\Models\User;

class InsertDefaultUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::transaction(function () {
            $defaults = ['owner_id' => 1, 'role_id' => 1, 'nin' => null, 'is_active' => 1];

            $users = [
                ['password' => '$2y$10\$MkcUlQGX9ME2VT8SMCQ4fuzPcf0H55vGDizd/hKblYvQ1OdfYGtDO', 'first_name' => 'Adi', 'last_name' => 'Ocneanu', 'email' => 'aocneanu@gmail.com', 'phone' => '0722443377'],
                ['password' => '$2y$10$/SM/4KgBJF/CErwhftKRVelzRJwGK0puek6/OnBmX/AWN347kXXOe', 'first_name' => 'Mihai', 'last_name' => 'Ocneanu', 'email' => 'mihai.ocneanu@gmail.com', 'phone' => '23424234324'],
                ['password' => '$2y$10\$hBeoRS4SUshJJoW/Nt5hZ.VwXEOWpdcJgz6QFmdeIEKrIiWvEySvq', 'first_name' => 'Ionut', 'last_name' => 'Pirvulescu', 'email' => 'ionut@itc-advisory.ro', 'phone' => '234324324'],
                ['password' => '$2y$10\$JpzGa.ncdz8e/MOGNOTQvuYa8m0mU1ufhiTKPfoWmh/yfK7YSgvjS', 'first_name' => 'Dorin', 'last_name' => 'Carsin', 'email' => 'dorin.carsin@gmail.com', 'phone' => '0745766997'],
                ['password' => '$2y$10\$IFr21wUI1uBupNYMwgiGFeWApxOLHi80kZ9XSYRFdP8gHCU109l9.', 'first_name' => 'Cristi', 'last_name' => 'Trif', 'email' => 'cristi@evolution-team.ro', 'phone' => ''],
            ];

            foreach ($users as $user) {
                $user = new User($user);
                $user->fill($defaults);

                $user->save();
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
