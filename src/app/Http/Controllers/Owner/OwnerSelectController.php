<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class OwnerSelectController extends Controller
{
    use SelectListBuilder;

    protected $selectQuery;

    public function __construct()
    {
        parent::__construct();

        $this->selectQuery = Owner::active();
    }
}
