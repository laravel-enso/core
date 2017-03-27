<?php

namespace LaravelEnso\Core\app\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Menu;
use LaravelEnso\Core\app\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $menu = request()->user()->role->menu;

        return view('laravel-enso/core::pages.home.index', compact('menu'));
    }
}
