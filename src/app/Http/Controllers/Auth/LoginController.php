<?php

namespace LaravelEnso\Core\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Auth\LoginController as Controller;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected $redirectTo = '/';

    protected function attemptLogin(Request $request)
    {
        $user = User::whereEmail($request->input('email'))
            ->first();

        if (is_null($user) || ! $user->isCurrentPassword($request->input('password'))) {
            return false;
        }

        if ($user->passwordExpired()) {
            throw new AuthenticationException(__(
                'Your password has expired. Please use the reset password form to set a new one'
            ));
        }

        if ($user->isDisabled()) {
            throw new AuthenticationException(__(
                'Your account has been disabled. Please contact the administrator'
            ));
        }

        auth()->login($user, $request->input('remember'));

        return true;
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'auth' => auth()->check(),
            'csrfToken' => csrf_token(),
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
    }
}
