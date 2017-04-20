<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->route('user');
        $email = 'required|email|unique:users';

        if ($this->_method == 'PATCH') {
            $email .= ','.$user->id.',id';
        }

        return [
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'is_active'  => 'required|in:"1","0"',
            'role_id'    => 'required|numeric|exists:roles,id',
            'owner_id'   => 'required|numeric|exists:owners,id',
            'email'      => $email,
            'phone'      => ['max:20', 'regex:^[0-9+\(\)#\.\s\/ext-]+$^'],
        ];
    }
}
