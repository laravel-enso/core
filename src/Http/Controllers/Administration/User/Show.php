<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Core\Services\ProfileBuilder;

class Show extends Controller
{
    public function __invoke(User $user)
    {
        (new ProfileBuilder($user))->set();

        return ['user' => $user];
    }
}
