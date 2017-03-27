<?php

namespace LaravelEnso\Core\app\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicies
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function updateProfile($user, $profileUser)
    {
        return $user->id === $profileUser->id;
    }

    public function impersonate($user, $profileUser)
    {
        return $user->hasAccessTo('administration.users.impersonate')
        && $user->id !== $profileUser->id
        && !$user->isImpersonating();
    }
}
