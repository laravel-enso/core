<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\User;

class Destroy extends Controller
{
    use AuthorizesRequests;

    public function __invoke(User $user)
    {
        $this->authorize('handle', $user);

        $user->delete();

        return [
            'message' => __('The user was successfully deleted'),
            'redirect' => 'administration.users.index',
        ];
    }
}
