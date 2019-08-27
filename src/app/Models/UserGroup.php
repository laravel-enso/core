<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Roles\app\Traits\HasRoles;
use LaravelEnso\Tables\app\Traits\TableCache;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserGroup extends Model
{
    use HasRoles, TableCache;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class, 'group_id');
    }

    public function delete()
    {
        if ($this->users()->count()) {
            throw new ConflictHttpException(
                __("The user group has users attached and can't be deleted")
            );
        }

        parent::delete();
    }

    public function scopeVisible($query)
    {
        return auth()->user()->belongsToAdminGroup()
            ? $query
            : $query->whereId(auth()->user()->group_id);
    }
}
