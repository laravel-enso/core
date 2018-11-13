<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateUserGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $nameUnique = Rule::unique('user_groups', 'name');

        $nameUnique = ($this->method() === 'PATCH')
            ? $nameUnique->ignore($this->route('userGroup')->id)
            : $nameUnique;

        return [
            'name' => ['required', $nameUnique],
            'description' => 'nullable',
            'roles' => 'array',
        ];
    }
}
