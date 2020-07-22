<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User\Token;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Forms\Builders\TokenForm;
use LaravelEnso\Core\Models\User;

class Create extends Controller
{
    public function __invoke(TokenForm $form, User $user)
    {
        return ['form' => $form->create($user)];
    }
}
