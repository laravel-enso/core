<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\Inspiring;
use LaravelEnso\Core\app\Enums\Themes;

class HomeController extends Controller
{
    public function __invoke()
    {
        $inspiringQuote = Inspiring::quote();
        $theme = (new Themes())->get(request()->user()->preferences->global->theme);

        return view('laravel-enso/core::home.index', compact('inspiringQuote', 'theme'));
    }
}
