<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\Owner;

use Illuminate\Routing\Controller;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;
use LaravelEnso\Core\app\Tables\Builders\OwnerTable;

class OwnerTableController extends Controller
{
    use Datatable, Excel;

    protected $tableClass = OwnerTable::class;
}
