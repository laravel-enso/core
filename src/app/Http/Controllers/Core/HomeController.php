<?php

namespace LaravelEnso\Core\app\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        $menu = request()->user()->role->menu;

        return view('laravel-enso/core::pages.home.index', compact('menu'));
    }
}
