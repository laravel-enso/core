<?php

namespace App\Http\Controllers\Administration;

use App\DataTable\OwnersTableStructure;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateOwnerRequest;
use App\Owner;
use LaravelEnso\Core\app\Enums\IsActiveEnum;
use LaravelEnso\Core\app\Models\Role;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class OwnersController extends Controller
{
    use DataTable, SelectListBuilder;

    protected $tableStructureClass = OwnersTableStructure::class;
    protected $selectSourceClass = 'LaravelEnso\Core\app\Models\Owner';

    public function getTableQuery()
    {
        $query = Owner::select(\DB::raw('id as DT_RowId, name, is_active'));

        return $query;
    }

    public function index()
    {
        return view('laravel-enso/core::pages.administration.owners.index');
    }

    public function create()
    {
        $isActiveEnum = new IsActiveEnum();
        $statuses = $isActiveEnum->getData();

        return view('laravel-enso/core::pages.administration.owners.create', compact('statuses'));
    }

    public function store(ValidateOwnerRequest $request, Owner $owner)
    {
        $owner->fill($request->all());

        $owner->save();

        flash()->success(__('The Entity was created!'));

        return redirect('administration/owners/'.$owner->id.'/edit');
    }

    public function show()
    {
        //
    }

    public function edit(Owner $owner)
    {
        $owner->roles_list;
        $isActiveEnum = new IsActiveEnum();
        $statuses = $isActiveEnum->getData();
        $roles = Role::all()->pluck('name', 'id');

        return view('laravel-enso/core::pages.administration.owners.edit', compact('owner', 'roles', 'statuses'));
    }

    public function update(ValidateOwnerRequest $request, Owner $owner)
    {
        \DB::transaction(function () use ($request, $owner) {
            $owner->fill($request->all());
            $owner->save();
            $rolesList = $request->roles_list ?: [];
            $owner->roles()->sync($rolesList);

            flash()->success(__('The Changes have been saved!'));
        });

        return back();
    }

    public function destroy(Owner $owner)
    {
        try {
            $owner->delete();
        } catch (\Exception $exception) {
            return [
                'level'   => 'error',
                'message' => __('An error has occured. Please report this to the administrator'),
            ];
        }

        return [
            'level'   => 'success',
            'message' => __('Operation was successfull'),
        ];
    }
}
