<?php

namespace LaravelEnso\Core\app\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController as Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\app\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->maxAttempts = config('enso.auth.maxLoginAttempts');
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();

        if (! optional($user)->currentPasswordIs($request->input('password'))) {
            return false;
        }

        if ($user->passwordExpired()) {
            throw new AuthenticationException(__(
                'Your password has expired. Please use the reset password form to set a new one'
            ));
        }

        if ($user->isInactive()) {
            throw new AuthenticationException(__(
                'Your account has been disabled. Please contact the administrator'
            ));
        }

        Auth::login($user, $request->input('remember'));

        return true;
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'auth' => Auth::check(),
            'csrfToken' => csrf_token(),
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
    }
}
