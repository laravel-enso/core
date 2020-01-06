<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Forms\Builders\UserGroupForm;

class Create extends Controller
{
    public function __invoke(UserGroupForm $form)
    {
        return ['form' => $form->create()];
    }
}
