<?php

namespace LaravelEnso\Core\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LaravelEnso\Core\Notifications\ResetPassword;

trait Logout
{
    public function logout(Request $request)
    {
        if ($request->attributes->get('sanctum')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
        } else {
            $request->user()->currentAccessToken()->delete();
        }
    }
}
