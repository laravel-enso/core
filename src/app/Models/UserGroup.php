<?php

namespace LaravelEnso\Core\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\App\Exceptions\UserGroupConflict;
use LaravelEnso\Rememberable\App\Traits\Rememberable;
use LaravelEnso\Roles\App\Traits\HasRoles;
use LaravelEnso\Tables\App\Traits\TableCache;

class UserGroup extends Model
{
    use HasRoles, Rememberable, TableCache;

    protected $fillable = ['name', 'description'];

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
