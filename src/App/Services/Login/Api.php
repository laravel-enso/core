<?php

namespace LaravelEnso\Core\App\Services\Login;

use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use LaravelEnso\Core\App\Models\User;

class Api extends Login
{
    public function logout()
    {
        $this->request->user()
            ->currentAccessToken()->delete();
    }

    public function login()
    {
        $this->clearLoginAttempts($this->request);

        return [
            'token' => $this->user->createToken($this->request->get('device_name'))
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
        $this->user = $user;
    }
}
