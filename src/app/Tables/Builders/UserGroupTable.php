<?php

namespace LaravelEnso\Core\app\Tables\Builders;

use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\VueDatatable\app\Classes\Table;

class UserGroupTable extends Table
{
    protected $templatePath = __DIR__.'/../Templates/userGroups.json';

    public function query()
    {
        return UserGroup::select(\DB::raw('
            id as "dtRowId", name, description, created_at
        '));
    }
}
