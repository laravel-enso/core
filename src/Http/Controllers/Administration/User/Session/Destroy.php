<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User\Session;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\Session;
use LaravelEnso\Core\Models\User;

class Destroy extends Controller
{
    use AuthorizesRequests;

    public function __invoke(Request $request, User $user)
    {
        Session::find($request->get('id'))
            ->delete();

        return [
            'message' => __('The session was deleted successfully'),
        ];
    }
}
