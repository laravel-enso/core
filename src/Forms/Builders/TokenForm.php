<?php

namespace LaravelEnso\Core\Forms\Builders;

use LaravelEnso\Core\Models\User;
use LaravelEnso\Forms\Services\Form;

class TokenForm
{
    protected const TemplatePath = __DIR__.'/../Templates/token.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form(self::TemplatePath);
    }

    public function create(User $user)
    {
        return $this->form
            ->routeParams(['user' => $user->id])
            ->create();
    }
}
