<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\NullableFields\Traits\NullableFields;

class Menu extends Model
{
    use NullableFields;

    protected $fillable = ['name', 'icon', 'link', 'has_children', 'parent_id'];
    protected $nullable = ['parent_id'];

    public function roles()
    {
        return $this->belongsToMany('LaravelEnso\Core\Models\Role')->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo('LaravelEnso\Core\Models\Menu');
    }

    public function getRolesListAttribute()
    {
        return $this->roles->pluck('id')->toArray();
    }
}
