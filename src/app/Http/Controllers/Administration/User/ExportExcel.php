<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Excel;
use LaravelEnso\Core\app\Tables\Builders\UserTable;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = UserTable::class;
}
