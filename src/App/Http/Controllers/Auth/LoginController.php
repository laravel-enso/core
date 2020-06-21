<?php

namespace LaravelEnso\Core\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController as Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Core\App\Events\Login;
use LaravelEnso\Core\App\Exceptions\Authentication;
use LaravelEnso\Core\App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    private ?User $user;

    public function __construct()
    {
        $this->maxAttempts = Config::get('enso.auth.maxLoginAttempts');
    }

    public function logout(Request $request)
    {
        if ($request->attributes->get('sanctum')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
        } else {
            $request->user()->currentAccessToken()->delete();
        }
    }

    protected function attemptLogin(Request $request)
    {
        $this->user = $this->loggableUser($request);

        if (! $this->user) {
            return false;
        }

        if ($request->attributes->get('sanctum')) {
            Auth::guard('web')->login($this->user, $request->input('remember'));
        }

        Login::dispatch($this->user, $request->ip(), $request->header('User-Agent'));

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($request->attributes->get('sanctum')) {
            $request->session()->regenerate();

            return [
                'auth' => Auth::check(),
                'csrfToken' => csrf_token(),
            ];
        }

        $token = $this->user->createToken($request->get('device_name'));

        return response()->json(['token' => $token->plainTextToken])
            ->cookie('is-webview', true)
            ->cookie('Authorization', $token->plainTextToken);
    }

    protected function validateLogin(Request $request)
    {
        $attributes = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        if (! $request->attributes->get('sanctum')) {
            $attributes['device_name'] = 'required|string';
        }

        $request->validate($attributes);
    }

    private function loggableUser(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();

        if (! optional($user)->currentPasswordIs($request->input('password'))) {
            return;
        }

        if ($user->passwordExpired()) {
            throw Authentication::expiredPassword();
        }

        if ($user->isInactive()) {
            throw Authentication::disabledAccount();
        }

        return $user;
    }
}
