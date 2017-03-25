<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateOwnerRequest extends FormRequest
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
        $owner = $this->route('owner');
        $name = 'required|max:50|unique:owners,name';

        if ($this->_method == 'PATCH') {
            $name .= ','.$owner->id.',id';
        }

        return [
            'name'          => $name,
            'is_active'     => 'required|in:"1","0"',
        ];
    }
}
