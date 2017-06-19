<?php

namespace LaravelEnso\Core\app\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\Inspiring;

class HomeController extends Controller
{
    public function __invoke()
    {
        $menu = request()->user()->role->menu;
        $inspiringQuote = Inspiring::quote();

        return view('laravel-enso/core::pages.home.index', compact('menu', 'inspiringQuote'));
    }
}
