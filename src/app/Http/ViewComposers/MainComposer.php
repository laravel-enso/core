<?php

namespace LaravelEnso\Core\app\Http\ViewComposers;

use Illuminate\View\View;
use LaravelEnso\Core\app\Classes\MenuManager\MenuGenerator;
use LaravelEnso\Core\app\Enums\ThemesEnum;
use LaravelEnso\Core\app\Models\Language;

class MainComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $user;
    protected $menu;
    protected $languages;
    protected $preferences;
    protected $theme;
    protected $themes;
    protected $userTheme;
    protected $pusherKey;

    /**
     * Create a new profile composer.
     *
     * @param UserRepository $users
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = request()->user();
        $this->menu = new MenuGenerator($this->user->role->menus->sortBy('order'));
        $this->languages = Language::all();
        $this->themes = (new ThemesEnum())->getJsonData();
        $this->pusherKey = env('PUSHER_APP_KEY');
        $this->preferences = $this->user->global_preferences;
        $this->theme = json_decode($this->preferences)->theme;
        $this->collapsedSidebar = json_decode($this->preferences)->collapsedSidebar ? 'sidebar-collapse' : '';
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
            'user'             => $this->user,
            'menu'             => $this->menu,
            'languages'        => $this->languages,
            'themes'           => $this->themes,
            'theme'            => $this->theme,
            'pusherKey'        => $this->pusherKey,
            'preferences'      => $this->preferences,
            'collapsedSidebar' => $this->collapsedSidebar,
        ]);
    }
}
