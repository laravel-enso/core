<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\UserGroup;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class UserGroupSelectController extends Controller
{
    use OptionsBuilder;

    protected $model = UserGroup::class;
}
