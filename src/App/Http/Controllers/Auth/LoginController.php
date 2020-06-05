<?php

namespace LaravelEnso\Core\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController as Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use LaravelEnso\Core\App\Events\Login;
use LaravelEnso\Core\App\Exceptions\Authentication;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\Core\App\Services\Login\Api;
use LaravelEnso\Core\App\Services\Login\Login as Service;
use LaravelEnso\Core\App\Services\Login\Spa;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected Service $login;

    public function __construct()
    {
        $this->maxAttempts = config('enso.auth.maxLoginAttempts');
    }

    public function logout(Request $request)
    {
        $this->service($request)
            ->logout();
    }

    protected function sendLoginResponse(Request $request)
    {
        return $this->service($request)
            ->login();
    }

    protected function validateLogin(Request $request)
    {
        $request->validate($this->service($request)->validation());
    }

    protected function attemptLogin(Request $request)
    {
        $user = $this->loggableUser($request);

        if (! $user) {
            return false;
        }

        $this->service($request)->loginAs($user);

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

    private function service(Request $request): Service
    {
        return $this->login ??= $request->attributes->get('sanctum')
            ? new Spa(request())
            : new Api(request());
    }
}
