<?php

namespace LaravelEnso\Core\App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\App\Enums\ResourcePermissionsEnum;
use LaravelEnso\Core\App\Http\Requests\ValidateResourcePermissionsRequest;
use LaravelEnso\Core\App\Models\Permission;
use LaravelEnso\Core\App\Models\PermissionsGroup;

class ResourcePermissionsController extends Controller
{
    public function create()
    {
        $permissionsGroups = PermissionsGroup::all()->pluck('name', 'id');

        return view('laravel-enso/core::pages.system.permissions.createResource', compact('permissionsGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateResourcePermissionsRequest $request)
    {
        $routes = $this->getRoutesCollection($request);

        \DB::transaction(function () use ($routes) {
            $routes->each(function ($route) {
                $permission = new Permission($route);
                $permission->save();
                $permission->roles()->attach(1);
            });
        });

        flash()->success(__('The Operation was successfull'));

        return view('laravel-enso/core::pages.system.permissions.index');
    }

    private function getRoutesCollection($request)
    {
        $resourcePermissions = new ResourcePermissionsEnum();
        $permissions = $resourcePermissions->getData();
        $routes = $permissions['resource'];

        if ($request->hasDataTables) {
            $routes = array_merge($routes, $permissions['dataTables']);
        }

        if ($request->hasVueSelect) {
            $routes = array_merge($routes, $permissions['vueSelect']);
        }

        foreach ($routes as &$route) {
            $route['name'] = $request->prefix.'.'.$route['name'];
            $route['permissions_group_id'] = $request->permissions_group_id;
        }

        return collect($routes);
    }
}
