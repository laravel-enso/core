<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\UserGroup;

class Destroy extends Controller
{
    public function __invoke(UserGroup $userGroup)
    {
        $userGroup->delete();

        return [
            'message' => __('The user group was successfully deleted'),
            'redirect' => 'administration.userGroups.index',
        ];
    }
}
