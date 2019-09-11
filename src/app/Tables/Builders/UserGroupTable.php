<?php

namespace LaravelEnso\Core\app\Tables\Builders;

use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Tables\app\Services\Table;

class UserGroupTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/userGroups.json';

    public function query()
    {
        return UserGroup::selectRaw('id, name, description, created_at');
    }
}
