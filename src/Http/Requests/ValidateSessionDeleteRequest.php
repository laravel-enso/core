<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Models\Session;

class ValidateSessionDeleteRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->isAdmin()
            || Auth::user()->id === Session::find($this->get('id'))->user_id;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:sessions,id',
        ];
    }
}
