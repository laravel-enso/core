<?php

namespace LaravelEnso\Core\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Traits\IsActive;
use LaravelEnso\RoleManager\app\Models\Role;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class Owner extends Model
{
    use IsActive;

    protected $fillable = ['name', 'description', 'is_active'];

    protected $attributes = ['is_active' => false];

    protected $casts = ['is_active' => 'boolean'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getRoleListAttribute()
    {
        return $this->roles->pluck('id');
    }

    public function updateWithRoles(array $attributes, array $roles)
    {
        tap($this)->update($attributes)
            ->roles()
            ->sync($roles);
    }

    public function storeWithRoles(array $attributes, array $roles)
    {
        $this->fill($attributes);

        tap($this)->save()
            ->roles()
            ->sync($roles);

        return $this;
    }

    public function delete()
    {
        if ($this->users()->count()) {
            throw new ConflictHttpException(
                __("The owner can't be deleted because it has users attached")
            );
        }

        parent::delete();
    }
}
