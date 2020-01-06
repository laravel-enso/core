<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Http\Requests\ValidateUserGroupRequest;
use LaravelEnso\Core\App\Models\UserGroup;

class Store extends Controller
{
    public function __invoke(ValidateUserGroupRequest $request, UserGroup $userGroup)
    {
        $userGroup = $userGroup->storeWithRoles($request->validated());

        return [
            'message' => __('The user group was successfully created'),
            'redirect' => 'administration.userGroups.edit',
            'param' => ['userGroup' => $userGroup->id],
        ];
    }
}
