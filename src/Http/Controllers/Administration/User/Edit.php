<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Forms\Builders\UserForm;
use LaravelEnso\Core\Models\User;

class Edit extends Controller
{
    public function __invoke(User $user, UserForm $form)
    {
        return ['form' => $form->edit($user)];
    }
}
