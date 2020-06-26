<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\UserGroup;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    public function query()
    {
        return UserGroup::visible();
    }
}
