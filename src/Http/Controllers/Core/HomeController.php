<?php

namespace LaravelEnso\Core\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\Models\Menu;
use App\User;

class HomeController extends Controller
{

    public function index()
    {
        $menu = request()->user()->role->menu;

        return view('core::pages.home.index', compact('menu'));
    }
}
