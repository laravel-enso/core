<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidateTokenRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->isAdmin()
            || Auth::user()->id === $this->route('user')->id;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }
}
