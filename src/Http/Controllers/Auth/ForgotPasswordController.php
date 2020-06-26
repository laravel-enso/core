<?php

namespace LaravelEnso\Core\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ForgotPasswordController extends Controller
{
    use ValidatesRequests, SendsPasswordResetEmails;

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }
}
