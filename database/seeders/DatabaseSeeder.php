<?php

namespace LaravelEnso\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use LaravelEnso\Countries\Database\Seeders\CountrySeeder;
use LaravelEnso\Localisation\Database\Seeders\LanguageSeeder;
use LaravelEnso\Roles\Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserGroupSeeder::class,
            UserSeeder::class,
            LanguageSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
