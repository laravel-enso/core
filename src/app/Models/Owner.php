<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = ['name', 'is_active'];

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

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
