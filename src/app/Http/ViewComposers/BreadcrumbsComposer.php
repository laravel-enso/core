<?php

namespace LaravelEnso\Core\app\Http\ViewComposers;

use Illuminate\View\View;
use LaravelEnso\Core\app\Classes\BreadcrumbsBuilder;

class BreadcrumbsComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $breadcrumbs;

    /**
     * Create a new profile composer.
     *
     * @param UserRepository $users
     *
     * @return void
     */
    public function __construct()
    {
        $breadcrumbsBuilder = new BreadcrumbsBuilder(request()->user()->role->menus->sortBy('order'));
        $this->breadcrumbs = $breadcrumbsBuilder->getBreadcrumbs();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
}
