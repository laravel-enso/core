<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Tables\app\Traits\Datatable;
use LaravelEnso\Core\app\Tables\Builders\UserTable;

class Table extends Controller
{
    use Datatable, Excel;

    protected $tableClass = UserTable::class;
}
