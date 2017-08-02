<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\Core\app\Http\Requests\ValidateOwnerRequest;
use LaravelEnso\Core\app\Http\Services\OwnerService;
use LaravelEnso\Core\app\Models\Owner;

class OwnerController extends Controller
{
    private $owners;

    public function __construct(Request $request)
    {
        $this->owners = new OwnerService($request);
    }

    public function index()
    {
        return view('laravel-enso/core::administration.owners.index');
    }

    public function create()
    {
        return $this->owners->create();
    }

    public function store(ValidateOwnerRequest $request, Owner $owner)
    {
        return $this->owners->store($owner);
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
