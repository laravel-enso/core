<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\Core\app\DataTable\OwnersTableStructure;
use LaravelEnso\Core\app\Http\Requests\ValidateOwnerRequest;
use LaravelEnso\Core\app\Http\Services\OwnerService;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class OwnerController extends Controller
{
    use DataTable, SelectListBuilder;

    private $owners;

    protected $selectSourceClass = Owner::class;
    protected $tableStructureClass = OwnersTableStructure::class;

    public function __construct(Request $request)
    {
        $this->owners = new OwnerService($request);
    }

    public function getTableQuery()
    {
        return $this->owners->getTableQuery();
    }

    public function index()
    {
        return $this->owners->index();
    }

    public function create()
    {
        return $this->owners->create();
    }

    public function store(ValidateOwnerRequest $request, Owner $owner)
    {
        return $this->owners->store($owner);
    }

    public function show()
    {
        //
    }

    public function edit(Owner $owner)
    {
        return $this->owners->edit($owner);
    }

    public function update(ValidateOwnerRequest $request, Owner $owner)
    {
        return $this->owners->update($owner);
    }

    public function destroy(Owner $owner)
    {
        return $this->owners->destroy($owner);
    }
}
