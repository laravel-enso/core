<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\Inspiring;

class HomeController extends Controller
{
    public function __invoke()
    {
        $menu = request()->user()->role->menu;
        $inspiringQuote = Inspiring::quote();

        return view('laravel-enso/core::home.index', compact('menu', 'inspiringQuote'));
    }
}
