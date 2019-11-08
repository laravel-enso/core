<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateUserGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', $this->nameUnique()],
            'description' => 'nullable',
            'roles' => 'array',
        ];
    }

    protected function nameUnique()
    {
        return Rule::unique('user_groups', 'name')
            ->ignore(optional($this->route('userGroup'))->id);
    }
}
