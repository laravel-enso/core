<?php

namespace LaravelEnso\Core\app\Forms\Builders;

use LaravelEnso\Forms\app\Services\Form;
use LaravelEnso\Core\app\Models\UserGroup;

class UserGroupForm
{
    protected const TemplatePath = __DIR__.'/../Templates/userGroup.json';

    protected $form;

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
        return $this->form
            ->edit($userGroup);
    }
}
