<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Tables\Builders\UserTable;
use LaravelEnso\Tables\app\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = UserTable::class;
}
