<?php

namespace LaravelEnso\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Exceptions\UserGroupConflict;
use LaravelEnso\Helpers\Traits\HasFactory;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Roles\Traits\HasRoles;
use LaravelEnso\Tables\Traits\TableCache;

class UserGroup extends Model
{
    use HasFactory, HasRoles, Rememberable, TableCache;

    protected $guarded = ['id'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'group_id');
    }

    public function delete()
    {
        if ($this->users()->exists()) {
            throw UserGroupConflict::hasUsers();
        }

        parent::delete();
    }

    public function scopeVisible($query)
    {
        return $query->when(
            ! Auth::user()->belongsToAdminGroup(),
            fn ($query) => $query->whereId(Auth::user()->group_id)
        );
    }
}
