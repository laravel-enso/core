<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class Session extends Model
{
    public $incrementing = false;

    public function scopeFor(Builder $builder, User $user)
    {
        $builder->whereUserId($user->id);
    }

    public function agent(): Agent
    {
        return new Agent(null, $this->user_agent);
    }
}
