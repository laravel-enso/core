<?php

namespace LaravelEnso\Core\App\Services\Upgrades;

use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Core\App\Models\UserGroup;
use LaravelEnso\People\App\Enums\Titles;
use LaravelEnso\People\App\Models\Person;
use LaravelEnso\Permissions\App\Models\Permission;
use LaravelEnso\Roles\App\Models\Role;
use LaravelEnso\Upgrade\App\Contracts\MigratesData;

class ControlPanel implements MigratesData
{
    private const email = 'monitoring@laravel-enso.com';
    private ?Person $person;

    public function migrateData(): void
    {
        factory(User::class)->create([
            'person_id' => $this->person()->id,
            'group_id' => $this->group()->id,
            'email' => $this->person()->email,
            'password' => '!',
            'role_id' => $this->role()->id,
            'is_active' => true,
        ])->generateAvatar();
    }

    public function isMigrated(): bool
    {
        return User::whereEmail(static::email)->exists();
    }

    private function person()
    {
        return $this->person ??= factory(Person::class)->create([
            'title' => Titles::Mr,
            'name' => 'Monitoring',
            'appellative' => 'Monitoring',
            'email' => self::email,
            'birthday' => '1924-12-24',
            'phone' => '+40793232522',
        ]);
    }

    private function group()
    {
        return factory(UserGroup::class)->create([
            'name' => 'Api',
            'description' => 'Api group',
        ]);
    }

    private function role()
    {
        $role = factory(Role::class)->create([
            'menu_id' => null,
            'name' => 'api',
            'display_name' => 'Api',
            'description' => 'Api role.'
        ]);

        $role->permissions()->sync(Permission::controlPanel()->pluck('id'));

        return $role;
    }
}
