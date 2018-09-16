<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\Owner;

use App\Http\Controllers\Controller;
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
