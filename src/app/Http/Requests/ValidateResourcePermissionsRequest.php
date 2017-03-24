<?php

namespace LaravelEnso\Core\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateResourcePermissionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prefix'               => 'required',
            'permissions_group_id' => 'required|exists:permissions_groups,id',
        ];
    }
}
