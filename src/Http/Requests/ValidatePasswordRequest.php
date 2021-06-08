<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
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
                fn ($field, $password, $fail) => $this
                    ->distinctPassword($password, $fail),
            ],
        ];
    }

    public function withValidator($validator)
    {
        if ($this->filled('email', 'password')) {
            $this->validatePassword($validator);
        }
    }

    protected function distinctPassword($password, $fail)
    {
        if ($this->filled('password')) {
            $user = $this->route('user')
                ?? User::whereEmail($this->get('email'))->first();

            if ($user->currentPasswordIs($password)) {
                $fail(__('You cannot use the existing password'));
            }
        }
    }
}
