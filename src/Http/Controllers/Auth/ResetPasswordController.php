<?php

namespace LaravelEnso\Core\Http\Controllers\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use LaravelEnso\Core\Http\Requests\ValidatePassword;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ResetPasswordController extends Controller
{
    use ValidatesRequests;
    use ResetsPasswords;

    protected $redirectTo = '/login';

    public function attemptReset(ValidatePassword $request)
    {
        return $this->reset($request);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    protected function resetPassword($user, $password)
    {
        Auth::setUser($user);

        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw new UnprocessableEntityHttpException(trans($response));
    }
}
