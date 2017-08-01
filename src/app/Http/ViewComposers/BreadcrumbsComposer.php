<?php

namespace LaravelEnso\Core\app\Http\ViewComposers;

use Illuminate\View\View;
use LaravelEnso\MenuManager\app\Classes\BreadcrumbsBuilder;

class BreadcrumbsComposer
{
    protected $breadcrumbs;

    public function __construct()
    {
        $builder = new BreadcrumbsBuilder(
            request()->user()->role
                ->menus()
                ->orderBy('order')
                ->get()
        );

        $this->breadcrumbs = $builder->get();
    }

    public function compose(View $view)
    {
        $view->with([
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
}
