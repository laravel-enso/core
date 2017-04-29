<?php

namespace LaravelEnso\Core\app\Http\Controllers\System;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\MenuManager\TreeMenuBuilder;
use LaravelEnso\Core\app\DataTable\MenusTableStructure;
use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\Core\app\Http\Requests\ValidateMenuRequest;
use LaravelEnso\Core\app\Models\Menu;
use LaravelEnso\Core\app\Models\Role;
use LaravelEnso\DataTable\app\Traits\DataTable;

class MenusController extends Controller
{
    use DataTable;

    protected $tableStructureClass = MenusTableStructure::class;

    public static function getTableQuery()
    {
        $query = Menu::select(\DB::raw('menus.id as DT_RowId, menus.name, menus.icon, parent_menus.name as parent, menus.link, menus.created_at, menus.updated_at'))
            ->leftJoin('menus as parent_menus', 'menus.parent_id', '=', 'parent_menus.id');

        return $query;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laravel-enso/core::pages.system.menus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isActiveEnum = new IsActiveEnum();
        $hasChildrenOptions = $isActiveEnum->getData();
        $menus = Menu::whereHasChildren(1)->pluck('name', 'id');

        return view('laravel-enso/core::pages.system.menus.create', compact('hasChildrenOptions', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateMenuRequest $request
     * @param Menu                $menu
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateMenuRequest $request, Menu $menu)
    {
        $menu->fill($request->all());

        \DB::transaction(function () use ($request, $menu) {
            $menu->save();
            $menu->roles()->attach(1); // admin

            flash()->success(__('Menu Created'));
        });

        return redirect('system/menus/'.$menu->id.'/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $isActiveEnum = new IsActiveEnum();
        $hasChildrenOptions = $isActiveEnum->getData();
        $menus = Menu::whereHasChildren(true)->pluck('name', 'id');
        $roles = Role::all()->pluck('name', 'id');
        $menu->roles_list;

        return view('laravel-enso/core::pages.system.menus.edit', compact('menu', 'hasChildrenOptions', 'menus', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateMenuRequest $request, Menu $menu)
    {
        \DB::transaction(function () use ($request, $menu) {
            $menu->fill($request->all());
            $menu->save();
            $roles = $request->roles_list ? $request->roles_list : [];
            $menu->roles()->sync($roles);

            flash()->success(__('The Changes have been saved!'));
        });

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        if ($menu->children_list->count()) {
            return [
                'level'   => 'error',
                'message' => __('Menu Has Children'),
            ];
        }

        $menu->delete();

        return [
            'level'   => 'success',
            'message' => __('Operation was successfull'),
        ];
    }

    public function reorder()
    {
        $menus = Menu::orderBy('order')->get();
        $menuGenerator = new TreeMenuBuilder($menus);
        $treeMenu = $menuGenerator->getData();

        return view('laravel-enso/core::pages.system.menus.reorder', compact('treeMenu'));
    }

    public function setOrder()
    {
        \DB::transaction(function () {
            $menus = request('menus');
            $this->updateMenu($menus, null);
        });

        flash()->success(__('The Changes have been saved!'));
    }

    private function updateMenu($menus, $id)
    {
        $order = 0;

        foreach ($menus as $element) {
            $order++;
            $menu = Menu::find($element['unique_id']);
            $menu->parent_id = $id;
            $menu->has_children = false;

            if (count($element['children'])) {
                $menu->has_children = true;
                $this->updateMenu($element['children'], $element['unique_id']);
            }

            $menu->order = $order;
            $menu->save();
        }
    }
}
