<?php

namespace LaravelEnso\Core\app\Tables\Builders;

use LaravelEnso\Core\app\Models\User;
use LaravelEnso\VueDatatable\app\Classes\Table;

class UserTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/users.json';

    public function query()
    {
        return User::select(\DB::raw(
                'users.id, users.id as "dtRowId", avatars.id as avatarId, owners.name as owner,
                users.first_name, users.last_name, users.phone, users.email, roles.name as role,
                users.is_active'
            ))->join('owners', 'users.owner_id', '=', 'owners.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('avatars', 'users.id', '=', 'avatars.user_id');
    }
}
