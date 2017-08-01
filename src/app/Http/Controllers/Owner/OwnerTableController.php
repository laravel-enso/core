<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\DataTable\OwnersTableStructure;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\DataTable\app\Traits\DataTable;

class OwnerTableController extends Controller
{
    use DataTable;

    protected $tableStructureClass = OwnersTableStructure::class;

    public function getTableQuery()
    {
        return Owner::select(\DB::raw('id as DT_RowId, name, description, is_active'));
    }
}
