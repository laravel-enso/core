<?php

namespace LaravelEnso\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use LaravelEnso\Core\Models\User as Model;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\UserGroups\Enums\UserGroups;

class User
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function profile(Model $user, Model $targetUser)
    {
        return $user->isSupervisor() || $user->is($targetUser);
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

    public function sessions(Model $user, Model $targetUser)
    {
        return $user->id === $targetUser->id;
    }

    protected function isSuperior(Model $user, Model $targetUser): bool
    {
        return $user->isSupervisor() && ! $targetUser->isSupervisor()
            && ! $targetUser->isAdmin();
    }
}
