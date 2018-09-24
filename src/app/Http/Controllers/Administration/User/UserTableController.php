<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;
use LaravelEnso\Core\app\Tables\Builders\UserTable;

class UserTableController extends Controller
{
    use Datatable, Excel;

    protected $tableClass = UserTable::class;
}
