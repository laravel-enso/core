<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePermissionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $permission = $this->route('permission');
        $name       = $this->_method == 'PATCH' ? 'required|unique:permissions,name,' . $permission->id . ',id'
            : 'required|unique:permissions,name';

        return [
            'permissions_group_id' => 'required',
            'name'                 => $name,
            'description'          => 'required',
            'type'                 => 'required',
        ];
    }
}
