<?php

namespace LaravelEnso\Core\App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicies
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function updateProfile(User $user, User $profileUser)
    {
        return $user->id === $profileUser->id;
    }

    public function impersonate(User $user, User $profileUser)
    {
        return $user->hasAccessTo('administration.users.impersonate')
            && $user->id !== $profileUser->id
            && !$user->isImpersonating();
    }
}
