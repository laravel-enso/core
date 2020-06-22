<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use LaravelEnso\Core\App\Models\UserGroup;

class UserGroupSeeder extends Seeder
{
    private const UserGroups = [
        ['name' => 'Administrators', 'description' => 'Administrator users group'],
        ['name' => 'Api', 'description' => 'Api users group'],
    ];

    public function run()
    {
        (new Collection(self::UserGroups))
            ->each(fn ($userGroup) => factory(UserGroup::class)->create($userGroup));
    }
}
