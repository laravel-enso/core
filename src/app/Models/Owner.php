<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Traits\IsActive;
use LaravelEnso\Contacts\app\Traits\Contactable;
use LaravelEnso\RoleManager\app\Traits\HasRoles;
use LaravelEnso\ActivityLog\app\Traits\LogActivity;
use LaravelEnso\Discussions\app\Traits\Discussable;
use LaravelEnso\CommentsManager\app\Traits\Commentable;
use LaravelEnso\AddressesManager\app\Traits\Addressable;
use LaravelEnso\DocumentsManager\app\Traits\Documentable;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Owner extends Model
{
    use IsActive, HasRoles, LogActivity, Contactable, Commentable,
        Discussable, Documentable, Addressable;

    protected $fillable = ['name', 'description', 'is_active'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

    protected $loggableLabel = 'name';

    protected $loggable = ['name', 'description', 'is_active' => 'active state'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function delete()
    {
        if ($this->users()->count()) {
            throw new ConflictHttpException(
                __("The owner has users attached and can't be deleted")
            );
        }

        parent::delete();
    }
}
