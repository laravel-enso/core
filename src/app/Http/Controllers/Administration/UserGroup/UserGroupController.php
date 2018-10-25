<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Core\app\Forms\Builders\UserGroupForm;
use LaravelEnso\Core\app\Http\Requests\ValidateUserGroupRequest;

class UserGroupController extends Controller
{
    public function create(UserGroupForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateUserGroupRequest $request, UserGroup $userGroup)
    {
        $userGroup = $userGroup->storeWithRoles($request->validated());

        return [
            'message' => __('The user group was successfully created'),
            'redirect' => 'administration.userGroups.edit',
            'param' => ['userGroup' => $userGroup->id],
        ];
    }

    public function edit(UserGroup $userGroup, UserGroupForm $form)
    {
        return ['form' => $form->edit($userGroup)];
    }

    public function update(ValidateUserGroupRequest $request, UserGroup $userGroup)
    {
        $userGroup->updateWithRoles($request->validated());

        return ['message' => __('The user group was successfully updated')];
    }

    public function destroy(UserGroup $userGroup)
    {
        $userGroup->delete();

        return [
            'message' => __('The user group was successfully deleted'),
            'redirect' => 'administration.userGroups.index',
        ];
    }
}
