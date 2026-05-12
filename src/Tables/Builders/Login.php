<?php

namespace LaravelEnso\Core\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Core\Models\Login as Model;
use LaravelEnso\Tables\Contracts\Table;

class Login implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/logins.json';

    public function query(): Builder
    {
        return Model::with(['user.avatar', 'user.person', 'user.role'])->selectRaw('
            logins.id, logins.user_id, people.name, users.email, roles.name as role,
            logins.ip, logins.user_agent, logins.created_at
        ')->join('users', 'logins.user_id', '=', 'users.id')
            ->join('people', 'users.person_id', '=', 'people.id')
            ->join('roles', 'users.role_id', '=', 'roles.id');
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
