<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PreferencesController extends Controller
{
    public function setPreferences(Request $request)
    {
        if ($request->has('global')) {
            auth()->user()
                ->setGlobalPreferences($request->get('global'));

            return;
        }

        auth()->user()
            ->setLocalPreferences(
                $request->get('route'),
                $request->get('value')
            );
    }

    public function setDefault(Request $request)
    {
        $request->user()
            ->persistDefaultPreferences();
    }
}
