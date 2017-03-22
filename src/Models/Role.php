<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = ['name', 'display_name', 'description', 'menu_id'];

    public function menus()
    {
        return $this->belongsToMany('LaravelEnso\Core\Models\Menu')->withTimestamps();
    }

    //returns implicit menu
    public function menu()
    {
        return $this->belongsTo('LaravelEnso\Core\Models\Menu');
    }

    public function owners()
    {
        return $this->belongsToMany('App\Owner');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('LaravelEnso\Core\Models\Permission')->withTimestamps();
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
