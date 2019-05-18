<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Tables\app\Traits\Data;
use LaravelEnso\Core\app\Tables\Builders\UserTable;

class TableData extends Controller
{
    use Data;

    protected $tableClass = UserTable::class;
}
