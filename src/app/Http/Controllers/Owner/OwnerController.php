<?php

namespace LaravelEnso\Core\app\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Core\app\Http\Services\OwnerService;
use LaravelEnso\Core\app\Http\Requests\ValidateOwnerRequest;

class OwnerController extends Controller
{
    public function __construct(OwnerService $service)
    {
        $this->service = $service;
    }

    public function create(Owner $owner)
    {
        return $this->service->create($owner);
    }

    public function store(ValidateOwnerRequest $request, Owner $owner)
    {
        return $this->service->store($request, $owner);
    }

    public function edit(Owner $owner)
    {
        return $this->service->edit($owner);
    }

    public function update(ValidateOwnerRequest $request, Owner $owner)
    {
        return $this->service->update($request, $owner);
    }

    public function destroy(Owner $owner)
    {
        return $this->service->destroy($owner);
    }
}
