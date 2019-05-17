<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Services\ProfileBuilder;

class Show extends Controller
{
    public function __invoke(User $user)
    {
        (new ProfileBuilder($user))->set();

        return ['user' => $user];
    }
}
