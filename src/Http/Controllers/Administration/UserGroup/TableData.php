<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Tables\Builders\UserGroupTable;
use LaravelEnso\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = UserGroupTable::class;
}
