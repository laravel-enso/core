<?php

namespace LaravelEnso\Core\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\RoleManager\app\Models\Role;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class OwnerService
{
    const FormPath = __DIR__.'/../../Forms/owner.json';

    public function create(Owner $owner)
    {
        $form = (new FormBuilder(self::FormPath, $owner))
            ->setMethod('POST')
            ->setTitle('Create Owner')
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return compact('form', 'owner');
    }

    public function store(Request $request, Owner $owner)
    {
        \DB::transaction(function () use ($request, &$owner) {
            $owner = $owner->create($request->all());
            $owner->roles()->sync($request->get('roleList'));
        });

        return [
            'message' => __('The entity was created!'),
            'redirect' => 'administration.owners.edit',
            'id' => $owner->id,
        ];
    }

    public function edit(Owner $owner)
    {
        $owner->append(['roleList']);

        $form = (new FormBuilder(self::FormPath, $owner))
            ->setMethod('PATCH')
            ->setTitle('Edit Owner')
            ->setSelectOptions('roleList', Role::pluck('name', 'id'))
            ->getData();

        return compact('form', 'owner');
    }

    public function update(Request $request, Owner $owner)
    {
        \DB::transaction(function () use ($request, $owner) {
            $owner->update($request->all());
            $owner->roles()->sync($request->get('roleList'));
        });

        return [
            'message' => __(config('enso.labels.savedChanges')),
        ];
    }

    public function destroy(Owner $owner)
    {
        if ($owner->users()->count()) {
            throw new ConflictHttpException(
                __("The owner can't be deleted because it has users attached")
            );
        }

        $owner->delete();

        return [
            'message' => __(config('enso.labels.successfulOperation')),
            'redirect' => 'administration.owners.index',
        ];
    }
}
