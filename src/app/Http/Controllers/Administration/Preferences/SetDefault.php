<?php

namespace LaravelEnso\Core\app\Http\Controllers\Preferences;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SetDefault extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()
            ->persistDefaultPreferences();
    }
}
