<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRoleRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $role = $this->route('role');
        $name = $this->_method == 'PATCH' ? 'required|unique:roles,name,' . $role->id . ',id'
            : 'required|unique:roles,name';

        return [
            'name'         => $name,
            'display_name' => 'required',
            'menu_id'      => 'required',
        ];
    }
}
