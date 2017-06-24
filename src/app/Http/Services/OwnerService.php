<?php

namespace LaravelEnso\Core\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\RoleManager\app\Models\Role;

class OwnerService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getTableQuery()
    {
        return Owner::select(\DB::raw('id as DT_RowId, name, is_active'));
    }

    public function index()
    {
        return view('laravel-enso/core::administration.owners.index');
    }

    public function create()
    {
        $statuses = (new IsActiveEnum())->getData();

        return view('laravel-enso/core::administration.owners.create', compact('statuses'));
    }

    public function store(Owner $owner)
    {
        $owner = $owner->create($this->request->all());
        flash()->success(__('The Entity was created!'));

        return redirect('administration/owners/' . $owner->id . '/edit');
    }

    public function edit(Owner $owner)
    {
        $owner->roles_list;
        $statuses = (new IsActiveEnum())->getData();
        $roles = Role::pluck('name', 'id');

        return view('laravel-enso/core::administration.owners.edit', compact('owner', 'roles', 'statuses'));
    }

    public function update(Owner $owner)
    {
        \DB::transaction(function () use ($owner) {
            $owner->update($this->request->all());
            $rolesList = $this->request->has('roles_list') ? $this->request->get('roles_list') : [];
            $owner->roles()->sync($rolesList);
        });

        flash()->success(__('The Changes have been saved!'));

        return back();
    }

    public function destroy(Owner $owner)
    {
        if ($owner->users()->count()) {
            throw new \EnsoException(__("The owner can't be deleted because it has users attached"));
        }

        $owner->delete();

        return ['message' => __('Operation was successfull')];
    }
}
