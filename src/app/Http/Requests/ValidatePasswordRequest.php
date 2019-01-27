<?php

namespace LaravelEnso\Core\app\Http\Requests;

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
        $validator->after(function ($validator) {
            (new PasswordValidator($this, $validator))
                ->handle();
        });
    }
}
