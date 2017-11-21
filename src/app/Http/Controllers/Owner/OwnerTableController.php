<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\VueDatatable\app\Classes\Template;
use LaravelEnso\Core\app\DataTable\OwnersTableStructure;
use LaravelEnso\VueDatatable\app\Classes\Table;

class OwnerTableController extends Controller
{
    use DataTable;

    protected $tableStructureClass = OwnersTableStructure::class;

    public function getTableQuery()
    {
        return Owner::select(\DB::raw('id as DT_RowId, name, description, is_active'));
    }

    public function query()
    {
        return Owner::select(\DB::raw('id as dtRowId, id, name, description, is_active, created_at'));
    }

    public function initTable() // will be init
    {
        $template = new Template(app_path('Tables/owners.json'));

        return $template->get();
    }

    public function getTableData(Request $request)
    {
        $table = new Table($request, $this->query());

        return $table->get();
    }

    public function exportExcel(Request $request)
    {
        \Log::notice($request->all());

        return [
            'message' => __(config('enso.labels.emailReportRequest')),
        ];
    }
}
