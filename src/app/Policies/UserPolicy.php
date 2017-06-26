<?php

namespace LaravelEnso\Core\app\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function updateProfile($user, $profileUser)
    {
        return $user->id === $profileUser->id;
    }

    public function impersonate($user, $profileUser)
    {
        return $user->can('access-route', 'core.impersonate.start')
            && $user->id !== $profileUser->id
            && !$user->isImpersonating();
    }
}
