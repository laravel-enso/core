<?php

namespace LaravelEnso\Core\App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\App\Models\Menu;
use LaravelEnso\Core\App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $menu = request()->user()->role->menu;

        return view('laravel-enso/core::pages.home.index', compact('menu'));
    }
}
