<?php

namespace LaravelEnso\Core\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\TransientToken;

trait Logout
{
    public function logout(Request $request)
    {
        if ($this->shouldLogout($request)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
        } else {
            $request->user()->currentAccessToken()->delete();
        }
    }

    private function shouldLogout(Request $request): bool
    {
        return $request->attributes->get('sanctum')
            || $request->user()->currentAccessToken() instanceof TransientToken;
    }
}
