<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $owner = $this->route('owner');
        $nameUnique = Rule::unique('owners', 'name');
        $nameUnique = ($this->_method == 'PATCH') ? $nameUnique->ignore($owner->id) : $nameUnique;
        \Log::info($nameUnique);
        return [
            'is_active'     => 'required|in:"1","0"',
            'name'          => [
                'required',
                $nameUnique,
            ],
        ];
    }
}
