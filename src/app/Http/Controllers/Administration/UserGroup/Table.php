<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Tables\app\Traits\Datatable;
use LaravelEnso\Core\app\Tables\Builders\UserGroupTable;

class Table extends Controller
{
    use Datatable, Excel;

    protected $tableClass = UserGroupTable::class;
}
