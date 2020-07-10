<?php

namespace LaravelEnso\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use LaravelEnso\Core\Enums\UserGroups;
use LaravelEnso\Core\Models\User as Model;
use LaravelEnso\Roles\Models\Role;

class User
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function handle(Model $user, Model $targetUser)
    {
        return ! $targetUser->isAdmin()
            && $targetUser->group_id === $user->group_id;
    }

    public function changeGroup(Model $user, Model $targetUser)
    {
        return ! $targetUser->isAdmin()
            && $user->isSupervisor()
            && $targetUser->group_id !== UserGroups::Admin;
    }

    public function changeRole(Model $user, Model $targetUser)
    {
        return ! $targetUser->isAdmin()
            && $user->id !== $targetUser->id
            && Role::visible()->whereId($targetUser->role_id)->exists();
    }

    public function changePassword(Model $user, Model $targetUser)
    {
        return $user->id === $targetUser->id
            || $this->isSuperior($user, $targetUser);
    }

    public function resetPassword(Model $user, Model $targetUser)
    {
        return $user->id === $targetUser->id
            || $this->isSuperior($user, $targetUser);
    }

    public function impersonate(Model $user, Model $targetUser)
    {
        return $user->can('access-route', 'core.impersonate.start')
            && ! $targetUser->isAdmin()
            && $user->id !== $targetUser->id
            && ! $user->isImpersonating();
    }


    protected function isSuperior(Model $user, Model $targetUser): bool
    {
        return $user->isSupervisor() && ! $targetUser->isSupervisor()
            && ! $targetUser->isAdmin();
    }
}
