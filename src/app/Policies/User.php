<?php

namespace LaravelEnso\Core\App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use LaravelEnso\Core\App\Enums\UserGroups;
use LaravelEnso\Core\App\Models\User as Model;
use LaravelEnso\Roles\App\Models\Role;

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
        return $user->id === $targetUser->id;
    }

    public function impersonate(Model $user, Model $targetUser)
    {
        return $user->can('access-route', 'core.impersonate.start')
            && ! $targetUser->isAdmin()
            && $user->id !== $targetUser->id
            && ! $user->isImpersonating();
    }
}
