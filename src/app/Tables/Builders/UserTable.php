<?php

namespace LaravelEnso\Core\app\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Tables\app\Contracts\Table;

class UserTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/users.json';

    protected $query;

    public function query(): Builder
    {
        return User::selectRaw('
            users.id, avatars.id as avatarId, user_groups.name as userGroup,
            people.name, people.appellative, people.phone, users.email, roles.name as role,
            users.is_active, users.created_at
        ')->join('people', 'users.person_id', '=', 'people.id')
        ->join('user_groups', 'users.group_id', '=', 'user_groups.id')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('avatars', 'users.id', '=', 'avatars.user_id');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
