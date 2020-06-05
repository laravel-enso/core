<?php

namespace LaravelEnso\Core\App\Http\Controllers\Auth\Login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaLoginController extends LoginController
{
    protected $redirectTo = '/';

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'auth' => Auth::check(),
            'csrfToken' => csrf_token(),
        ]);
    }

    protected function loginAs($user, Request $request)
    {
        $this->guard()
            ->login($user, $request->input('remember'));
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
