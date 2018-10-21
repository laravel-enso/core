<?php

namespace LaravelEnso\Core\app\Policies;

use LaravelEnso\Core\app\Models\User;
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
        return ! $targetUser->isAdmin();
    }

    public function changePassword(User $user, User $targetUser)
    {
        return $user->id === $targetUser->id;
    }

    public function changeRole(User $user, User $targetUser)
    {
        return $user->id !== $targetUser->id
            && ! ($targetUser->isAdmin() && ! $user->isAdmin());
    }

    public function impersonate(User $user, User $targetUser)
    {
        return $user->can('access-route', 'core.impersonate.start')
            && ! $targetUser->isAdmin()
            && $user->id !== $targetUser->id
            && ! $user->isImpersonating();
    }
}
