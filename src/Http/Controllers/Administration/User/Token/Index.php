<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User\Token;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Http\Resources\Token;
use LaravelEnso\Core\Models\User;

class Index extends Controller
{
    public function __invoke(User $user)
    {
        return Token::collection($user->tokens);
    }
}
