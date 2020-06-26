<?php

namespace LaravelEnso\Core\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\Http\Requests\ValidatePasswordRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ResetPasswordController extends Controller
{
    use ValidatesRequests, ResetsPasswords;

    protected $redirectTo = '/';

    public function attemptReset(ValidatePasswordRequest $request)
    {
        return $this->reset($request);
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw new UnprocessableEntityHttpException(trans($response));
    }
}
