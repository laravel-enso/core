<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Core\app\Http\Requests\ValidateUserGroupUpdate;

class Update extends Controller
{
    public function __invoke(ValidateUserGroupUpdate $request, UserGroup $userGroup)
    {
        $userGroup->updateWithRoles($request->validated());

        return ['message' => __('The user group was successfully updated')];
    }
}
