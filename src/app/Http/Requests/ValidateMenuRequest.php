<?php

namespace LaravelEnso\Core\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateMenuRequest extends FormRequest
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
        $menu = $this->route('menu');
        $name = $this->_method == 'PATCH' ? 'required|unique:menus,name,'.$menu->id.',id'
            : 'required|unique:menus,name';

        return [

            'name'         => $name,
            'icon'         => 'required',
            'has_children' => 'required',
        ];
    }
}
