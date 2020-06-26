<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Tables\Builders\UserGroupTable;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = UserGroupTable::class;
}
