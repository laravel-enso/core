<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateUserRequest extends FormRequest
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
            'is_active'  => 'required|in:"1","0"',
            'role_id'    => 'required|numeric|exists:roles,id',
            'owner_id'   => 'required|numeric|exists:owners,id',
            'phone'      => ['max:20', 'regex:^[0-9+\(\)#\.\s\/ext-]+$^'],
            'email'      => [
                'email',
                'required',
                $emailUnique
            ],
        ];
    }
}
