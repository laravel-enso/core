<?php

namespace LaravelEnso\Core\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
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
        $form = (new FormBuilder(__DIR__.'/../../Forms/owner.json'))
            ->setAction('POST')
            ->setTitle('Create Owner')
            ->setUrl('/administration/owners')
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return view('laravel-enso/core::administration.owners.create', compact('form'));
    }

    public function store(Owner $owner)
    {
        \DB::transaction(function () use (&$owner) {
            $owner = $owner->create($this->request->all());
            $roleList = $this->request->get('roleList');
            $owner->roles()->sync($roleList);
        });

        return [
            'message'  => __('The entity was created!'),
            'redirect' => '/administration/owners/'.$owner->id.'/edit',
        ];
    }

    public function edit(Owner $owner)
    {
        $owner->append(['roleList']);

        $form = (new FormBuilder(__DIR__.'/../../Forms/owner.json', $owner))
            ->setAction('PATCH')
            ->setTitle('Edit Owner')
            ->setUrl('/administration/owners/'.$owner->id)
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return view('laravel-enso/core::administration.owners.edit', compact('form', 'owner'));
    }

    public function update(Owner $owner)
    {
        \DB::transaction(function () use ($owner) {
            $owner->update($this->request->all());
            $roleList = $this->request->get('roleList');
            $owner->roles()->sync($roleList);
        });

        return [
            'message' => __(config('labels.savedChanges')),
        ];
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
