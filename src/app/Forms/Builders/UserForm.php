<?php

namespace LaravelEnso\Core\app\Forms\Builders;

use LaravelEnso\Core\app\Models\User;
use LaravelEnso\FormBuilder\app\Classes\Form;

class UserForm
{
    private const TemplatePath = __DIR__.'/../Templates/user.json';

    private $form;

    public function __construct()
    {
        $this->form = new Form(self::TemplatePath);
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(User $user)
    {
        if (auth()->user()->can('change-password', $user)) {
            $this->form->show([
                'password', 'password_confirmation',
            ]);
        }

        return $this->form
            ->value('password', null)
            ->edit($user);
    }
}
