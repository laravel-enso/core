<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User\Token;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\User;

class Destroy extends Controller
{
    public function __invoke(Request $request, User $user)
    {
        $user->tokens()->whereId($request->get('id'))
            ->delete();

        return [
            'message' => __('The token was deleted successfully'),
        ];
    }
}
