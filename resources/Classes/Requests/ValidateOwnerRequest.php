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
        $owner      = $this->route('owner');
        $name       = 'required|max:50|unique:owners,name';
        $fiscalCode = 'required|unique:owners,fiscal_code';
        $regComNr   = 'unique:owners,reg_com_nr';

        if ($this->_method == 'PATCH') {
            $name       .= ',' . $owner->id . ',id';
            $fiscalCode .= ',' . $owner->id . ',id';
            $regComNr   .= ',' . $owner->id . ',id';
        }

        return [
            'name'          => $name,
            'email'         => ['max:100', 'regex:^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$^', 'unique:owners,email,' . $owner->id . ',id'],
            'phone'         => ['max:20', 'regex:^[0-9+\(\)#\.\s\/ext-]+$^'],
            'fiscal_code'   => $fiscalCode,
            'reg_com_nr'    => $regComNr,
            'is_individual' => 'required|in:"1","0"',
            'is_active'     => 'required|in:"1","0"',
        ];
    }
}
