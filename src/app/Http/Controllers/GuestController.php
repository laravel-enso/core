<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;

class GuestController extends Controller
{
    public function __invoke()
    {
        return [
            'appName' => config('app.name'),
            'i18n' => $this->i18n(),
        ];
    }

    private function i18n()
    {
        return [
                'Email' => __('Email'),
                'Password' => __('Password'),
                'Remember me' => __('Remember me'),
                'Forgot password' => __('Forgot password'),
                'Login' => __('Login'),
                'Send a reset passworkd link' => __('Send a reset passworkd link'),
                'Repeat Password' => __('Repeat Password'),
        ];
    }
}
