<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        $theme = auth()->user()->theme();

        return view('laravel-enso/core::index', compact('theme'));
    }
}
