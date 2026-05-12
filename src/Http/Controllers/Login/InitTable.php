<?php

namespace LaravelEnso\Core\Http\Controllers\Login;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\Tables\Builders\Login;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected $tableClass = Login::class;
}
