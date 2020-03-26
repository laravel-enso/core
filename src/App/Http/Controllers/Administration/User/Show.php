<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Core\App\Services\ProfileBuilder;

class Show extends Controller
{
    public function __invoke(User $user)
    {
        (new ProfileBuilder($user))->set();

        return ['user' => $user];
    }
}
