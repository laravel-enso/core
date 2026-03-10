<?php

namespace LaravelEnso\Core\Observers;

use LaravelEnso\Users\Models\User as Model;

class User
{
    public function created(Model $user)
    {
        $user->initPreferences();
    }
}
