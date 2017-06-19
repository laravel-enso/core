<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description', 'menu_id'];

    public function menus()
    {
        return $this->belongsToMany('LaravelEnso\MenuManager\app\Models\Menu')->withTimestamps();
    }

    //returns implicit menu
    public function menu()
    {
        return $this->belongsTo('LaravelEnso\MenuManager\app\Models\Menu');
    }

    public function owners()
    {
        return $this->belongsToMany('LaravelEnso\Core\app\Models\Owner');
    }

    public function users()
    {
        return $this->hasMany('LaravelEnso\Core\app\Models\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('LaravelEnso\PermissionManager\app\Models\Permission')->withTimestamps();
    }

    public function getPermissionsListAttribute()
    {
        return $this->permissions->pluck('id')->toArray();
    }

    public function getMenusListAttribute()
    {
        return $this->menus->pluck('id')->toArray();
    }
}
