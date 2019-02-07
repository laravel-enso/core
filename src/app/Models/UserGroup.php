<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\RoleManager\app\Traits\HasRoles;
use LaravelEnso\VueDatatable\app\Traits\TableCache;
use LaravelEnso\ActivityLog\app\Traits\LogsActivity;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserGroup extends Model
{
    use HasRoles, LogsActivity, TableCache, TableCache;

    const AdminGroupId = 1;

    protected $fillable = ['name', 'description'];

    protected $loggableLabel = 'name';

    protected $loggable = ['name', 'description'];

    protected $cachedTable = 'userGroups';

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
