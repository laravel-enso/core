<?php

namespace LaravelEnso\Core\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class, //TODO import
            UserGroupSeeder::class,
            UserSeeder::class,
            LanguageSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
