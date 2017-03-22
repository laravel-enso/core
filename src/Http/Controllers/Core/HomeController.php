<?php

namespace LaravelEnso\Core\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\User;
use LaravelEnso\Core\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        $menu = request()->user()->role->menu;

        return view('core::pages.home.index', compact('menu'));
    }
}
