<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePermissionsGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $permissionsGroup = $this->route('permissionsGroup');
        $name = $this->_method == 'PATCH' ? 'required|unique:permissions_groups,name,'.$permissionsGroup->id.',id'
            : 'required|unique:permissions_groups,name';

        return [

            'name'        => $name,
            'description' => 'required',
        ];
    }
}
