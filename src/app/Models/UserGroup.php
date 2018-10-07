<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Contacts\app\Traits\Contactable;
use LaravelEnso\RoleManager\app\Traits\HasRoles;
use LaravelEnso\Discussions\app\Traits\Discussable;
use LaravelEnso\ActivityLog\app\Traits\LogsActivity;
use LaravelEnso\CommentsManager\app\Traits\Commentable;
use LaravelEnso\AddressesManager\app\Traits\Addressable;
use LaravelEnso\DocumentsManager\app\Traits\Documentable;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserGroup extends Model
{
    use HasRoles, LogsActivity, Contactable, Commentable,
        Discussable, Documentable, Addressable;

    protected $fillable = ['name', 'description'];

    protected $loggableLabel = 'name';

    protected $loggable = ['name', 'description'];

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
}
