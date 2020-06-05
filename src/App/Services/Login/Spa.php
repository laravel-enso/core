<?php

namespace LaravelEnso\Core\App\Services\Login;

use Illuminate\Support\Facades\Auth;

class Spa extends Login
{
    public function logout()
    {
        $this->request->logout();

        $this->request
            ->session()->invalidate();
    }

    public function login($user)
    {
        $this->clearLoginAttempts($this->request);
        $this->request->session()->regenerate();

        return [
            'auth' => Auth::check(),
            'csrfToken' => csrf_token(),
        ];
    }

    public function loginAs($user)
    {
        Auth::guard('web')
            ->login($user, $this->request->input('remember'));
    }
}
