<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Http\Requests\ValidateUserGroupRequest;
use LaravelEnso\Core\app\Models\UserGroup;

class Update extends Controller
{
    public function __invoke(ValidateUserGroupRequest $request, UserGroup $userGroup)
    {
        $userGroup->updateWithRoles($request->validated());

        return ['message' => __('The user group was successfully updated')];
    }
}
