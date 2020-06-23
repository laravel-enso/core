<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Models\User;

class Token extends Controller
{
    public function __invoke(User $user)
    {
        return ['token' => $user->createToken('api')->plainTextToken];
    }
}
