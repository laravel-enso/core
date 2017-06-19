<?php

namespace LaravelEnso\Core\app\Http\Controllers\System;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\DataTable\RolesTableStructure;
use LaravelEnso\Core\app\Http\Requests\ValidateRoleRequest;
use LaravelEnso\Core\app\Models\Role;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\MenuManager\app\Models\Menu;
use LaravelEnso\PermissionManager\app\Models\Permission;
use LaravelEnso\PermissionManager\app\Models\PermissionGroup;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class RolesController extends Controller
{
    use DataTable, SelectListBuilder;

    protected $selectSourceClass = Role::class;
    protected $tableStructureClass = RolesTableStructure::class;

    public function getTableQuery()
    {
        $query = Role::select(\DB::raw('roles.id as DT_RowId, roles.name, roles.display_name, roles.description, roles.created_at, roles.updated_at, roles.menu_id'));

        return $query;
    }

    public function index()
    {
        return view('laravel-enso/core::pages.system.roles.index');
    }

    public function getPermissions(Role $role)
    {
        $menusList = ['menus' => Menu::all()];
        $permissionsGroups = PermissionGroup::with('permissions')->get();
        $roleMenusList = $role->menus->pluck('id');
        $rolePermissionsList = $role->permissions->pluck('id');
        $permissionsList = $this->buildPermissionGroupsStructure($permissionsGroups);

        return [
            'menusList'           => $menusList,
            'roleMenusList'       => $roleMenusList,
            'rolePermissionsList' => $rolePermissionsList,
            'permissionsList'     => $permissionsList,
        ];
    }

    public function setPermissions()
    {
        \DB::transaction(function () {
            $role = Role::find(request()->role_id);
            $role->menus()->sync(request()->roleMenusList);
            $role->permissions()->sync(request()->rolePermissionsList);
        });

        return [
            'level'   => 'success',
            'message' => __('Operation was successfull'),
        ];
    }

    public function create()
    {
        $menus = Menu::all()->pluck('name', 'id');

        return view('laravel-enso/core::pages.system.roles.create', compact('menus'));
    }

    public function store(ValidateRoleRequest $request)
    {
        $role = new Role();
        $role->fill($request->all());
        $role->save();
        $permissions = Permission::whereDefault(true)->pluck('id');
        $role->permissions()->attach($permissions);
        flash()->success(__('Role Created'));

        return redirect('system/roles/'.$role->id.'/edit');
    }

    public function edit(Role $role)
    {
        $menus = Menu::whereHasChildren(0)->pluck('name', 'id');

        return view('laravel-enso/core::pages.system.roles.edit', compact('role', 'menus'));
    }

    public function update(ValidateRoleRequest $request, Role $role)
    {
        $role->fill($request->all());
        $role->save();
        flash()->success(__('The Changes have been saved!'));

        return back();
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return [
            'level'   => 'success',
            'message' => __('Operation was successfull'),
        ];
    }

    private function buildPermissionGroupsStructure($permissionsGroups, $label = null)
    {
        $structure = [];
        $labels = [];

        foreach ($permissionsGroups as $permissionsGroup) {
            if (!$label || strpos($permissionsGroup->name, $label) === 0) {
                if ($permissionsGroup->name == $label) {
                    return $permissionsGroup->permissions;
                }

                $remainingLabels = $label ? substr($permissionsGroup->name, strlen($label) + 1) : $permissionsGroup->name;
                $labelsArray = explode('.', $remainingLabels);
                $labels[] = $labelsArray[0];
            }
        }

        $labels = array_unique($labels);

        foreach ($labels as $currentLabel) {
            $structure[$currentLabel] = $this->buildPermissionGroupsStructure($permissionsGroups, $label ? $label.'.'.$currentLabel : $currentLabel);
        }

        return $structure;
    }
}
