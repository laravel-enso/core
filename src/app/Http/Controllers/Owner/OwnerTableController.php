<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\VueDatatable\app\Traits\Excel;
use LaravelEnso\VueDatatable\app\Traits\Datatable;

class OwnerTableController extends Controller
{
    use Datatable, Excel;

    private const Template = __DIR__.'/../../../Tables/owners.json';

    public function query()
    {
        return Owner::select(\DB::raw('id as "dtRowId", name, description, is_active, created_at'));
    }
}
