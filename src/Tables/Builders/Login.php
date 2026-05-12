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
        return Model::with(['user.avatar', 'user.person'])
            ->select(['id', 'user_id', 'ip', 'user_agent', 'created_at']);
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
