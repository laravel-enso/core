<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Traits\IsActive;
use LaravelEnso\RoleManager\app\Traits\HasRoles;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Owner extends Model
{
    use IsActive, HasRoles;

    protected $fillable = ['name', 'description', 'is_active'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

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
