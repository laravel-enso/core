<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Core\app\Forms\Builders\OwnerForm;
use LaravelEnso\Core\app\Http\Requests\ValidateOwnerRequest;

class OwnerController extends Controller
{
    public function create(OwnerForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateOwnerRequest $request, Owner $owner)
    {
        $owner->storeWithRoles($request->all(), $request->get('roleList'));

        return [
            'message' => __('The entity was created!'),
            'redirect' => 'administration.owners.edit',
            'id' => $owner->id,
        ];
    }

    public function edit(Owner $owner, OwnerForm $form)
    {
        return [
            'owner' => $owner,
            'form' => $form->edit($owner),
        ];
    }

    public function update(ValidateOwnerRequest $request, Owner $owner)
    {
        $owner->updateWithRoles($request->all(), $request->get('roleList'));

        return ['message' => __(config('enso.labels.savedChanges'))];
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return [
            'message' => __(config('enso.labels.successfulOperation')),
            'redirect' => 'administration.owners.index',
        ];
    }
}
