<?php

namespace LaravelEnso\Core\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $user = User::where('email', '=', request()->input('email'))->first();

        if (is_null($user) || !Hash::check(request()->input('password'), $user->password)) {
            return false;
        }

        if ($user->isDisabled()) {
            throw new AuthenticationException(__(
                'Your account has been disabled. Please contact the administrator'
            ));
        }

        auth()->login($user, request()->input('remember'));

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
