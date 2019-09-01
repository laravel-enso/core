<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateUserStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'person_id' => 'exists:people,id',
            'group_id' => 'required|exists:user_groups,id',
            'role_id' => 'required|exists:roles,id',
            'email' => ['email', 'required', $this->emailUnique()],
            'password' => 'nullable|confirmed|min:'.config('enso.auth.password.minLength'),
            'is_active' => 'boolean',
        ];
    }

    public function withValidator($validator)
    {
        if ($this->filled('password')) {
            $validator->after(function ($validator) {
                (new PasswordValidator(
                    $this, $validator, $this->route('user'))
                )->handle();
            });
        }
    }

    protected function emailUnique()
    {
        return Rule::unique('people', 'email')
            ->ignore($this->get('person_id'));
    }
}
