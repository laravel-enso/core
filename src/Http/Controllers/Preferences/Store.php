<?php

namespace LaravelEnso\Core\Http\Controllers\Preferences;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Store extends Controller
{
    public function __invoke(Request $request)
    {
        $preferences = Auth::user()->preferences;

        if ($request->has('global')) {
            $preferences->setGlobal($request->get('global'));
        } else {
            $preferences->setLocal($request->get('route'), $request->get('value'));
        }
    }
}
