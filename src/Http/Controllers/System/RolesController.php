<?php

namespace LaravelEnso\Core\Http\Controllers\System;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\DataTable\RolesTableStructure;
use LaravelEnso\Core\Http\Requests\ValidateRoleRequest;
use LaravelEnso\Core\Models\Menu;
use LaravelEnso\Core\Models\PermissionsGroup;
use LaravelEnso\Core\Models\Role;
use LaravelEnso\DataTable\Traits\DataTable;
use LaravelEnso\Select\Traits\SelectListBuilderTrait;

class RolesController extends Controller
{
    use DataTable, SelectListBuilderTrait;

    protected $selectSourceClass   = 'LaravelEnso\Core\Models\Role';
    protected $selectPivotParams   = ['owner_id' => 'owners'];
    protected $tableStructureClass = RolesTableStructure::class;

    public static function getTableQuery()
    {
        $query = Role::select(\DB::raw('roles.id as DT_RowId, roles.name, roles.display_name, roles.description, roles.created_at, roles.updated_at, roles.menu_id'));

        return $query;
    }

    public function index()
    {
        return view('core::pages.system.roles.index');
    }

    public function getPermissions(Role $role)
    {
        $menusList           = ['menus' => Menu::all()];
        $permissionsGroups   = PermissionsGroup::with('permissions')->get();
        $roleMenusList       = $role->menus->pluck('id');
        $rolePermissionsList = $role->permissions->pluck('id');
        $permissionsList     = $this->buildPermissionsGroupsStructure($permissionsGroups);

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
            'message' => __("Operation was successfull"),
        ];
    }

    public function create()
    {
        $menus = Menu::all()->pluck('name', 'id');

        return view('core::pages.system.roles.create', compact('menus'));
    }

    public function store(ValidateRoleRequest $request)
    {
        $role = new Role;
        $role->fill($request->all());
        $role->save();
        flash()->success(__('Role Created'));

        return redirect('system/roles/' . $role->id . '/edit');
    }

    public function edit(Role $role)
    {
        $menus = Menu::all()->pluck('name', 'id');

        return view('core::pages.system.roles.edit', compact('role', 'menus'));
    }

    public function update(ValidateRoleRequest $request, Role $role)
    {
        $role->fill($request->all());
        $role->save();
        flash()->success(__("The Changes have been saved!"));

        return back();
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return [
            'level'   => 'success',
            'message' => __("Operation was successfull"),
        ];
    }

    private function buildPermissionsGroupsStructure($permissionsGroups, $label = null)
    {
        $structure = [];
        $labels    = [];

        foreach ($permissionsGroups as $permissionsGroup) {
            if (!$label || strpos($permissionsGroup->name, $label) === 0) {
                if ($permissionsGroup->name == $label) {

                    return $permissionsGroup->permissions;
                } else {
                    $remainingLabels = $label ? substr($permissionsGroup->name, strlen($label) + 1) : $permissionsGroup->name;
                    $labelsArray     = explode('.', $remainingLabels);
                    $labels[]        = $labelsArray[0];
                }
            }
        }

        $labels = array_unique($labels);

        foreach ($labels as $currentLabel) {
            $structure[$currentLabel] = $this->buildPermissionsGroupsStructure($permissionsGroups, $label ? $label . '.' . $currentLabel : $currentLabel);
        }

        return $structure;
    }
}
