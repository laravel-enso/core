<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\Owner;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Core\app\Forms\Builders\OwnerForm;
use Illuminate\Foundation\Validation\ValidatesRequests;
use LaravelEnso\Core\app\Http\Requests\ValidateOwnerRequest;

class OwnerController extends Controller
{
    use ValidatesRequests;

    public function create(OwnerForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateOwnerRequest $request, Owner $owner)
    {
        $owner = $owner->storeWithRoles($request->validated());

        return [
            'message' => __('The owner was successfully created'),
            'redirect' => 'administration.owners.edit',
            'id' => $owner->id,
        ];
    }

    public function edit(Owner $owner, OwnerForm $form)
    {
        return ['form' => $form->edit($owner)];
    }

    public function update(ValidateOwnerRequest $request, Owner $owner)
    {
        $owner->updateWithRoles($request->validated());

        return ['message' => __('The owner was successfully updated')];
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return [
            'message' => __('The owner was successfully deleted'),
            'redirect' => 'administration.owners.index',
        ];
    }
}
