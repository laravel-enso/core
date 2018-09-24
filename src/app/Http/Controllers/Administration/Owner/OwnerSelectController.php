<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\Owner;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class OwnerSelectController extends Controller
{
    use OptionsBuilder;

    public function query()
    {
        return Owner::active();
    }
}
