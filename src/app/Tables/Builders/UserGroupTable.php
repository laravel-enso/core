<?php

namespace LaravelEnso\Core\app\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Tables\app\Contracts\Table;

class UserGroupTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/userGroups.json';

    public function query(): Builder
    {
        return UserGroup::selectRaw('id, name, description, created_at');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
