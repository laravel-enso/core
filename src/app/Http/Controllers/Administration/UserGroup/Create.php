<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Forms\Builders\UserGroupForm;

class Create extends Controller
{
    public function __invoke(UserGroupForm $form)
    {
        return ['form' => $form->create()];
    }
}
