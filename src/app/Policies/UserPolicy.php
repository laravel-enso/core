<?php

namespace LaravelEnso\Core\app\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use LaravelEnso\Core\app\Enums\UserGroups;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Roles\app\Models\Role;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function handle(User $user, User $targetUser)
    {
        return ! $targetUser->isAdmin()
            && $targetUser->group_id === $user->group_id;
    }

    public function changeGroup(User $user, User $targetUser)
    {
        return ! $targetUser->isAdmin()
            && $user->isSupervisor()
            && $targetUser->group_id !== UserGroups::Admin;
    }

    public function changeRole(User $user, User $targetUser)
    {
        return ! $targetUser->isAdmin()
            && $user->id !== $targetUser->id
            && Role::visible()
                ->whereId($targetUser->role_id)
                ->exists();
    }

    public function changePassword(User $user, User $targetUser)
    {
        return $user->id === $targetUser->id;
    }

    public function impersonate(User $user, User $targetUser)
    {
        return $user->can('access-route', 'core.impersonate.start')
            && ! $targetUser->isAdmin()
            && $user->id !== $targetUser->id
            && ! $user->isImpersonating();
    }

    private function canChangeRole(User $user, User $targetUser)
    {
        return  $user->id !== $targetUser->id
            && ! $targetUser->isAdmin()
            && Role::visible()->whereId($targetUser->role_id)->first() !== null;
    }
}
