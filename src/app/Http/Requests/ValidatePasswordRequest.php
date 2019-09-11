<?php

namespace LaravelEnso\Core\app\Http\Requests;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Foundation\Http\FormRequest;

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
            'password' => 'nullable|confirmed|min:'.config('enso.auth.password.minLength'),
        ];
    }

    public function withValidator($validator)
    {
        if ($this->filled('password')) {
            $this->validatePassword($validator);
        }
    }

    protected function validatePassword($validator)
    {
        $user = $this->route('user')
            ?? User::whereEmail($this->get('email'))->first();

        $validator->after(function ($validator) use ($user) {
            (new PasswordValidator(
                $this, $validator, $user
            ))->handle();
        });
    }
}
