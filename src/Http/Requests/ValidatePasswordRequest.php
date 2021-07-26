<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use LaravelEnso\Core\Rules\DistinctPassword;
use LaravelEnso\Users\Models\User;

class ValidatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'exists:users,email',
            'password' => [
                'nullable',
                'confirmed',
                Password::defaults(),
                new DistinctPassword($this->currentUser()),
            ],
        ];
    }

    protected function currentUser()
    {
        return $this->route('user')
            ?? User::whereEmail($this->get('email'))->first();
    }
}
