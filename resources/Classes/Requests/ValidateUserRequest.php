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

        if ($this->_method == 'PATCH') {
            $email = ['required', 'max:100', 'regex:^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$^', 'unique:users,email,' . $user->id . ',id'];
            $nin = 'max:13|unique:users,nin,' . $user->id . ',id|nin';
        } else {
            $email = ['required', 'max:100', 'regex:^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$^', 'unique:users'];
            $nin = 'max:13|unique:users|nin';
        }

        return [
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'is_active'  => 'required|in:"1","0"',
            'role_id'    => 'required|numeric|exists:roles,id',
            'owner_id'   => 'required|numeric|exists:owners,id',
            'email'      => $email,
            'phone'      => ['max:20', 'regex:^[0-9+\(\)#\.\s\/ext-]+$^'],
            'nin'        => $nin,
        ];
    }
}
