<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Forms\Builders\UserForm;
use LaravelEnso\People\App\Models\Person;

class Create extends Controller
{
    public function __invoke(Person $person, UserForm $form)
    {
        return ['form' => $form->create($person)];
    }
}
