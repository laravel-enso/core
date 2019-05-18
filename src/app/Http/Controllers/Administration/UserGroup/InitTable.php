<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Init;
use LaravelEnso\Core\app\Tables\Builders\UserGroupTable;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = UserGroupTable::class;
}
