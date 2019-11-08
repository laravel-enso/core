<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Forms\Builders\UserForm;
use LaravelEnso\People\app\Models\Person;

class Create extends Controller
{
    public function __invoke(Person $person, UserForm $form)
    {
        return ['form' => $form->create($person)];
    }
}
