<?php

namespace LaravelEnso\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use LaravelEnso\Core\Models\User;

class UserPolicies
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function viewProfilePage(User $user, User $profileUser)
    {
        return $user->id == $profileUser->id;
    }

    public function updateProfile(User $user, User $profileUser)
    {
        return $user->id == $profileUser->id;
    }

    public function impersonate(User $user, User $profileUser)
    {
        return $user->hasAccessTo('administration.users.impersonate') && $user->id !== $profileUser->id && !$user->isImpersonating();
    }
}
