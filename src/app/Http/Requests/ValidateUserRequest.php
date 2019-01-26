<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $emailUnique = Rule::unique('users', 'email');

        $emailUnique = ($this->method() === 'PATCH')
            ? $emailUnique->ignore($this->route('user')->id)
            : $emailUnique;

        return [
            'person_id' => 'exists:people,id',
            'group_id' => 'required|exists:user_groups,id',
            'role_id' => 'required|exists:roles,id',
            'email' => ['email', 'required', $emailUnique],
            'password' => 'nullable|confirmed|min:'.config('enso.config.password.minLength'),
            'is_active' => 'boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('password')) {
                $validator->after(function ($validator) {
                    (new PasswordValidator($this, $validator))
                        ->handle();
                });
            }
        });
    }
}
