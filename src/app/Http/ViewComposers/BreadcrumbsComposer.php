<?php

namespace LaravelEnso\Core\app\Http\ViewComposers;

use Illuminate\View\View;
use LaravelEnso\MenuManager\app\Classes\BreadcrumbsBuilder;

class BreadcrumbsComposer
{
    protected $breadcrumbs;

    public function __construct()
    {
        $breadcrumbsBuilder = new BreadcrumbsBuilder(request()->user()->role->menus->sortBy('order'));
        $this->breadcrumbs = $breadcrumbsBuilder->get();
    }

    public function compose(View $view)
    {
        $view->with([
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
}
