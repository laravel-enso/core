<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['permissions_group_id', 'name', 'description', 'type'];

    public function permissions_group()
    {
        return $this->belongsTo('LaravelEnso\Core\App\Models\PermissionsGroup');
    }

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\Core\App\Models\Role')->withTimestamps();
    }

    public function getRolesListAttribute()
    {
        return $this->roles->pluck('id')->toArray();
    }

    public function tutorials()
    {
        return $this->hasMany('LaravelEnso\TutorialManager\App\Models\Tutorial');
    }
}
