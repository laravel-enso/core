<?php

namespace LaravelEnso\Core\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use LaravelEnso\Core\Events\Login as Event;
use LaravelEnso\Core\Traits\Login;
use LaravelEnso\Core\Traits\Logout;
use LaravelEnso\Users\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers, Logout, Login {
        Logout::logout insteadof AuthenticatesUsers;
        Login::login insteadof AuthenticatesUsers;
    }

    protected $redirectTo = '/';

    private ?User $user;

    public function __construct()
    {
        $this->maxAttempts = Config::get('enso.auth.maxLoginAttempts');
    }

    protected function attemptLogin(Request $request)
    {
        $this->user = $this->loggableUser($request);

        if (!$this->user) {
            return false;
        }

        if ($request->attributes->get('sanctum')) {
            Auth::guard('web')->login($this->user, $request->input('remember'));
        }

        Event::dispatch($this->user, $request->ip(), $request->header('User-Agent'));

        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($request->attributes->get('sanctum')) {
            $request->session()->regenerate();

            return [
                'auth'      => Auth::check(),
                'csrfToken' => csrf_token(),
            ];
        }

        $token = $this->user->createToken($request->get('device_name'));

        return response()->json(['token' => $token->plainTextToken])
            ->cookie('webview', true)
            ->cookie('Authorization', $token->plainTextToken);
    }

    protected function validateLogin(Request $request)
    {
        $attributes = [
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ];

        if (!$request->attributes->get('sanctum')) {
            $attributes['device_name'] = 'required|string';
        }

        $request->validate($attributes);
    }

    private function loggableUser(Request $request)
    {
        $user = User::whereEmail($request->input('email'))->first();

        if (!$user?->currentPasswordIs($request->input('password'))) {
            return;
        }

        if ($user->passwordExpired()) {
            throw ValidationException::withMessages([
                'email' => 'Password expired. Please set a new one.',
            ]);
        }

        if ($user->isInactive()) {
            throw ValidationException::withMessages([
                'email' => 'Account disabled. Please contact the administrator.',
            ]);
        }

        return $user;
    }
}
