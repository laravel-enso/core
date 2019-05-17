<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Core\app\Http\Requests\ValidateUserGroupStore;

class Store extends Controller
{
    public function __invoke(ValidateUserGroupStore $request, UserGroup $userGroup)
    {
        $userGroup = $userGroup->storeWithRoles($request->validated());

        return [
            'message' => __('The user group was successfully created'),
            'redirect' => 'administration.userGroups.edit',
            'param' => ['userGroup' => $userGroup->id],
        ];
    }
}
