<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use LaravelEnso\Core\Rules\DistinctPassword;
use LaravelEnso\Users\Models\User;

class ValidatePassword extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'    => 'exists:users,email',
            'password' => [
                'nullable',
                'confirmed',
                Password::defaults(),
                $this->distinctPassword(),
            ],
        ];
    }

    protected function currentUser()
    {
        return $this->route('user')
            ?? User::whereEmail($this->get('email'))->first();
    }

    private function distinctPassword(): ?DistinctPassword
    {
        $user = $this->currentUser();

        return $user
            ? new DistinctPassword($this->currentUser())
            : null;
    }
}
