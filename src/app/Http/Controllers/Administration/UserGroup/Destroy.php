<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\UserGroup;

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
