<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;
use LaravelEnso\Core\app\Tables\Builders\UserGroupTable;

class UserGroupTableController extends Controller
{
    use Datatable, Excel;

    protected $tableClass = UserGroupTable::class;
}
