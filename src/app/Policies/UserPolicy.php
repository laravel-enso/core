<?php

namespace LaravelEnso\Core\app\Policies;

use LaravelEnso\Core\app\Models\User;
use LaravelEnso\RoleManager\app\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

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

    public function update(User $user, User $targetUser)
    {
        return $targetUser->isDirty('role_id')
            ? $this->canChangeRole($user, $targetUser) && ! $targetUser->isDirty('group_id')
            : ! $targetUser->isDirty('group_id');
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
