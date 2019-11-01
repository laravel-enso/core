<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Forms\Builders\UserGroupForm;
use LaravelEnso\Core\app\Models\UserGroup;

class Edit extends Controller
{
    public function __invoke(UserGroup $userGroup, UserGroupForm $form)
    {
        return ['form' => $form->edit($userGroup)];
    }
}
