<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Tables\Builders\UserTable;
use LaravelEnso\Tables\app\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = UserTable::class;
}
