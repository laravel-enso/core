<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;

class GuestController extends Controller
{
    public function __invoke()
    {
        return [
            'meta' => $this->meta(),
            'i18n' => $this->i18n(),
        ];
    }

    private function meta()
    {
        return [
            'appName' => config('app.name'),
        ];
    }

    private function i18n()
    {
        return [
            app()->getLocale() => [
                'Email' => __('Email'),
                'Password' => __('Password'),
                'Remember me' => __('Remember me'),
                'Forgot password' => __('Forgot password'),
                'Login' => __('Login'),
                'Send a reset passworkd link' => __('Send a reset passworkd link'),
                'Repeat Password' => __('Repeat Password'),
                'Success' => __('Success'),
                'Error' => __('Error'),
            ],
        ];
    }
}
