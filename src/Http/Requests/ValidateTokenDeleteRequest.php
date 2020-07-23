<?php

namespace LaravelEnso\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidateTokenDeleteRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::user()->isAdmin()
            || Auth::user()->id === $this->route('user')->id;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:personal_access_tokens,id',
        ];
    }
}
