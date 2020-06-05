<?php

namespace LaravelEnso\Core\App\Services\Login;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;

class Login
{
    use ThrottlesLogins;
    protected Request $request;

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
        return $this->request->user()->email;
    }
}
