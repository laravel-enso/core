<?php

namespace LaravelEnso\Core\App\Services\Login;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use LaravelEnso\Core\App\Models\User;

class Login
{
    use ThrottlesLogins;
    protected Request $request;
    protected User $user;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validation()
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    protected function username()
    {
        return $this->user->email;
    }
}
