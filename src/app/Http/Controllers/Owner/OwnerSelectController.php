<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class OwnerSelectController extends Controller
{
    use SelectListBuilder;

    protected $selectSourceClass = Owner::class;
}
