<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'name', 'is_active',
    ];

    public function users()
    {
        return $this->hasMany('LaravelEnso\Core\App\Models\User');
    }

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\Core\App\Models\Role');
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
