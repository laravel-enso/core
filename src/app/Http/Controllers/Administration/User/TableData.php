<?php

namespace LaravelEnso\Core\App\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\App\Tables\Builders\UserTable;
use LaravelEnso\Tables\App\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected $tableClass = UserTable::class;
}
