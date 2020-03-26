<?php

namespace LaravelEnso\Core\App\Forms\Builders;

use LaravelEnso\Core\App\Models\UserGroup;
use LaravelEnso\Forms\App\Services\Form;

class UserGroupForm
{
    protected const TemplatePath = __DIR__.'/../Templates/userGroup.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = (new Form(self::TemplatePath));
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(UserGroup $userGroup)
    {
        return $this->form->edit($userGroup);
    }
}
