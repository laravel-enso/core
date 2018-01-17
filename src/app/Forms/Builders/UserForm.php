<?php

namespace LaravelEnso\Core\app\Forms\Builders;

use LaravelEnso\Core\app\Models\User;
use LaravelEnso\FormBuilder\app\Classes\Form;

class UserForm
{
    private const FormPath = __DIR__.'/../Templates/user.json';

    private $form;

    public function __construct()
    {
        $this->form = new Form(self::FormPath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(User $user)
    {
        return $this->form->edit($user);
    }
}
