<?php

namespace LaravelEnso\Core\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ResetPasswordController as Controller;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ResetPasswordController extends Controller
{
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
