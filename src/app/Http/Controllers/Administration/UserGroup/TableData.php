<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Data;
use LaravelEnso\Core\app\Tables\Builders\UserGroupTable;

class TableData extends Controller
{
    use Data;

    protected $tableClass = UserGroupTable::class;
}
