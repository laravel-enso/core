<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Http\Requests\ValidateUserGroupRequest;
use LaravelEnso\Core\App\Models\UserGroup;

class Update extends Controller
{
    public function __invoke(ValidateUserGroupRequest $request, UserGroup $userGroup)
    {
        $userGroup->updateWithRoles($request->validated());

        return ['message' => __('The user group was successfully updated')];
    }
}
