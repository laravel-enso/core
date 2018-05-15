<?php

namespace LaravelEnso\Core\app\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class GuestI18n implements Responsable
{
    public function toResponse($request)
    {
        return [
            app()->getLocale() => [
                'Email' => __('Email'),
                'Password' => __('Password'),
                'Remember me' => __('Remember me'),
                'Forgot password' => __('Forgot password'),
                'Login' => __('Login'),
                'Send a reset password link' => __('Send a reset password link'),
                'Repeat Password' => __('Repeat Password'),
                'Success' => __('Success'),
                'Error' => __('Error'),
            ],
        ];
    }
}
