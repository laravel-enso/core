<?php

namespace LaravelEnso\Core\Http\Controllers\Login;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Tables\Builders\Login;
use LaravelEnso\Tables\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = Login::class;
}
