<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateProfilePageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->route('user');
        $emailUnique = Rule::unique('users', 'email');
        $emailUnique = ($this->_method == 'PATCH') ? $emailUnique->ignore($user->id) : $emailUnique;

        return [
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'phone'      => 'max:30',
            'email'      => [
                'email',
                'required',
                $emailUnique,
            ],
        ];
    }
}
