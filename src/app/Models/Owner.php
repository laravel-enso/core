<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Traits\IsActiveTrait;

class Owner extends Model
{
    use IsActiveTrait;

    protected $fillable = ['name', 'description', 'is_active'];

    public function users()
    {
        return $this->hasMany('LaravelEnso\Core\app\Models\User');
    }

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\RoleManager\app\Models\Role');
    }

    public function getRolesListAttribute()
    {
        return $this->roles->pluck('id')->toArray();
    }
}
