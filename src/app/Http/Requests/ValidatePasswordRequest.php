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
        $user = $this->route('user')
            ?? User::whereEmail($this->get('email'))->first();

        if ($this->filled('password')) {
            $validator->after(function ($validator) use ($user) {
                (new PasswordValidator(
                    $this, $validator, $user)
                )->handle();
            });
        }
    }
}
