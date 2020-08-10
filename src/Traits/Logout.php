<?php

namespace LaravelEnso\Core\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
