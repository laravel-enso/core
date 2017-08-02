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

    public function create()
    {
        $statuses = (new IsActiveEnum())->getData();

        return view('laravel-enso/core::administration.owners.create', compact('statuses'));
    }

    public function store(Owner $owner)
    {
        $owner = $owner->create($this->request->all());
        flash()->success(__('The Entity was created!'));

        return redirect('administration/owners/'.$owner->id.'/edit');
    }

    public function edit(Owner $owner)
    {
        $statuses = (new IsActiveEnum())->getData();
        $roles = Role::pluck('name', 'id');
        $owner->append(['roleList']);

        return view('laravel-enso/core::administration.owners.edit', compact('owner', 'roles', 'statuses'));
    }

    public function update(Owner $owner)
    {
        \DB::transaction(function () use ($owner) {
            $owner->update($this->request->all());
            $roleList = $this->request->has('roleList') ? $this->request->get('roleList') : [];
            $owner->roles()->sync($roleList);
        });

        flash()->success(__(config('labels.savedChanges')));

        return back();
    }

    public function destroy(Owner $owner)
    {
        if ($owner->users()->count()) {
            throw new \EnsoException(
                __("The owner can't be deleted because it has users attached")
            );
        }

        $owner->delete();

        return ['message' => __(config('labels.successfulOperation'))];
    }
}
