<?php

namespace LaravelEnso\Core\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ResetPasswordController extends Controller
{
    use ValidatesRequests, ResetsPasswords;

    protected $redirectTo = '/';

    protected function sendResetResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        throw new UnprocessableEntityHttpException(trans($response));
    }
}
