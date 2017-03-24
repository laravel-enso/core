<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionsGroup extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->hasMany('LaravelEnso\Core\App\Models\Permission');
    }
}
