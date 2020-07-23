<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User\Session;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\Http\Resources\Session as Resource;
use LaravelEnso\Core\Models\Session;
use LaravelEnso\Core\Models\User;

class Index extends Controller
{
    use AuthorizesRequests;

    public function __invoke(User $user)
    {
        $this->authorize('sessions', $user);

        return Resource::collection(Session::for($user)->get());
    }
}
