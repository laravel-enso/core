<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProfilePageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'max:30',
        ];
    }
}
