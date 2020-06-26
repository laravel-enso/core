<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Forms\Builders\UserForm;
use LaravelEnso\People\Models\Person;

class Create extends Controller
{
    public function __invoke(Person $person, UserForm $form)
    {
        return ['form' => $form->create($person)];
    }
}
