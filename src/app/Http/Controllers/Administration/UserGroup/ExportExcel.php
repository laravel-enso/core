<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\UserGroup;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Tables\Builders\UserGroupTable;
use LaravelEnso\Tables\app\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = UserGroupTable::class;
}
