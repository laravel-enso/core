<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description', 'menu_id'];

    public function menus()
    {
        return $this->belongsToMany('LaravelEnso\Core\App\Models\Menu')->withTimestamps();
    }

    //returns implicit menu
    public function menu()
    {
        return $this->belongsTo('LaravelEnso\Core\App\Models\Menu');
    }

    public function owners()
    {
        return $this->belongsToMany('LaravelEnso\Core\App\Models\Owner');
    }

    public function users()
    {
        return $this->hasMany('LaravelEnso\Core\App\Models\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('LaravelEnso\Core\App\Models\Permission')->withTimestamps();
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
