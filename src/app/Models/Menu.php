<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\NullableFields\app\Traits\NullableFields;

class Menu extends Model
{
    use NullableFields;

    protected $fillable = ['name', 'icon', 'link', 'has_children', 'parent_id'];
    protected $nullable = ['parent_id'];

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\Core\app\Models\Role')->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo('LaravelEnso\Core\app\Models\Menu');
    }

    public function getRolesListAttribute()
    {
        return $this->roles->pluck('id')->toArray();
    }

    public function getChildrenAttribute()
    {
        return Menu::whereParentId($this->id)->get();
    }
}
