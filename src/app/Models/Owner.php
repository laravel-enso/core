<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Traits\IsActiveTrait;
use LaravelEnso\RoleManager\app\Models\Role;

class Owner extends Model
{
    use IsActiveTrait;

    protected $fillable = ['name', 'description', 'is_active'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRoleListAttribute()
    {
        return $this->roles->pluck('id');
    }
}
