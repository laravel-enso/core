<?php

namespace LaravelEnso\Core\Http\Controllers\Login;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Tables\Builders\Login;
use LaravelEnso\Tables\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected $tableClass = Login::class;
}
