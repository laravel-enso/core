<?php

namespace LaravelEnso\Core\app\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ForgotPasswordController extends Controller
{
    use ValidatesRequests, SendsPasswordResetEmails;

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        throw new UnprocessableEntityHttpException(trans($response));
    }
}
