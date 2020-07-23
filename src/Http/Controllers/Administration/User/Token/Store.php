<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User\Token;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Http\Requests\ValidateTokenRequest;
use LaravelEnso\Core\Models\User;

class Store extends Controller
{
    public function __invoke(ValidateTokenRequest $request, User $user)
    {
        return [
            'message' => 'Token was generated successfully',
            'token' => $user->createToken($request->get('name'))->plainTextToken,
        ];
    }
}
