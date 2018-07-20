<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateTeamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $nameUnique = Rule::unique('teams', 'name');

        $nameUnique = $this->has('id')
            ? $nameUnique->ignore($this->get('id'))
            : $nameUnique;

        return [
            'name' => ['required', $nameUnique],
            'description' => 'string|nullable',
            'userList' => 'array'
        ];
    }
}
