<?php

namespace LaravelEnso\Core\app\Forms\Builders;

use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\FormBuilder\app\Classes\Form;

class UserGroupForm
{
    private const TemplatePath = __DIR__.'/../Templates/userGroup.json';

    private $form;

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
            ->value('roleList', $userGroup->roleList())
            ->edit($userGroup);
    }
}
