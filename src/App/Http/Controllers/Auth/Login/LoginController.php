<?php

namespace LaravelEnso\Core\App\Http\Controllers\Auth\Login;

use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Core\App\Events\Login;
use LaravelEnso\Core\App\Exceptions\Authentication;
use App\Http\Controllers\Auth\LoginController as Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

abstract class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->maxAttempts = config('enso.auth.maxLoginAttempts');
    }

    protected function attemptLogin(Request $request)
    {
        $user = $this->loggableUser($request);

        if (! $user) {
            return false;
        }

        $this->loginAs($user, $request);

        Login::dispatch($user, $request->ip(), $request->header('User-Agent'));

        return true;
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

    abstract protected function loginAs($user, Request $request);
}
