<?php

namespace LaravelEnso\Core\App\Services\Login;

use Illuminate\Support\Facades\Auth;

class Api extends Login
{
    public function logout()
    {
        $this->request->user()
            ->currentAccessToken()
            ->delete();
    }

    public function login($user)
    {
        $this->clearLoginAttempts($this->request);

        return [
            'token' => $user->createToken($this->request->get('device_name'))
                ->plainTextToken,
        ];
    }

    public function validation()
    {
        return parent::validation() + [
            'device_name' => 'required|string',
        ];
    }

    public function loginAs($user)
    {
        Auth::guard('web')
            ->login($user, $this->request->input('remember'));
    }
}
