<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\User;

class Token extends Controller
{
    public function __invoke(User $user)
    {
        return ['token' => $user->createToken('api')->plainTextToken];
    }
}
