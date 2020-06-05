<?php

namespace LaravelEnso\Core\App\Services\Login;

use Illuminate\Support\Facades\Auth;

class Spa extends Login
{
    public function logout()
    {
        Auth::guard('web')
            ->logout();

        $this->request
            ->session()->invalidate();
    }

    public function login()
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
        $this->user = $user;

        Auth::guard('web')
            ->login($user, $this->request->input('remember'));
    }
}
