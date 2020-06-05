<?php

namespace LaravelEnso\Core\App\Http\Controllers\Auth\Login;

use Laravel\Sanctum\Sanctum;
use LaravelEnso\Core\App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends LoginController
{
    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return response()->json([
            'token' => Auth::user()->createToken($request->get('device_name'))
                ->plainTextToken,
        ]);
    }

    protected function validateLogin(Request $request)
    {
        parent::validateLogin($request);

        $request->validate([
            'device_name' => 'required|string'
        ]);
    }

    protected function loginAs($user, Request $request)
    {
        Sanctum::actingAs($user);
    }
}
