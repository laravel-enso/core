<?php

namespace LaravelEnso\Core\app\Http\Controllers\Preferences;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Set extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->has('global')) {
            auth()->user()->setGlobalPreferences($request->get('global'));

            return;
        }

        auth()->user()->setLocalPreferences(
            $request->get('route'), $request->get('value')
        );
    }
}
