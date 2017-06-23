<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use LaravelEnso\ActionLogger\app\Models\ActionLog;
use LaravelEnso\Core\app\DataTable\UsersTableStructure;
use LaravelEnso\Core\app\Http\Requests\ValidateUserRequest;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\DataTable\app\Traits\DataTable;
use LaravelEnso\Impersonate\app\Traits\Controller\Impersonate;

class UsersController extends Controller
{
    use SendsPasswordResetEmails, DataTable, Impersonate;

    protected $tableStructureClass = UsersTableStructure::class;

    public function getTableQuery()
    {
        $query = User::select(\DB::raw('users.id as DT_RowId, owners.name owner, users.first_name, users.last_name, users.phone, users.email, roles.name role, users.is_active'))
            ->join('owners', 'users.owner_id', '=', 'owners.id')
            ->join('roles', 'users.role_id', '=', 'roles.id');

        return $query;
    }

    public function index()
    {
        return view('laravel-enso/core::administration.users.index');
    }

    public function create()
    {
        $user = new User();
        $roles = [];
        $owners = Owner::active()->pluck('name', 'id');

        return view('laravel-enso/core::administration.users.create', compact('owners', 'user', 'roles'));
    }

    public function store(ValidateUserRequest $request, User $user)
    {
        \DB::transaction(function () use (&$user) {
            $user->fill($request->all());
            $user->email = $request->email;
            $user->owner_id = $request->owner_id;
            $user->save();
            $this->sendResetLinkEmail($request);
        });

        flash()->success(__('The User was created!'));

        return redirect('administration/users/'.$user->id.'/edit');
    }

    public function show(User $user)
    {
        $user->load('owner')
            ->load('role')
            ->load('avatar');

        $timeline = ActionLog::whereUserId($user->id)->latest()->limit(10)->get();

        return view('laravel-enso/core::administration.users.show', compact('user', 'timeline'));
    }

    public function edit(User $user)
    {
        $owners = Owner::active()->pluck('name', 'id');
        $roles = $user->owner->roles->pluck('name', 'id');

        return view('laravel-enso/core::administration.users.edit', compact('user', 'roles', 'owners'));
    }

    public function update(ValidateUserRequest $request, User $user)
    {
        // $user->fill($request->all());

        $user->update($request->all());
        // $user->save();

        flash()->success(__('The Changes have been saved!'));

        return back();
    }

    public function updateProfile(ValidateUserRequest $request, User $user)
    {
        if (request()->user()->cannot('updateProfile', $user)) {
            flash()->warning(__('You are not authorized for this action'));

            return back();
        }

        $user->fill($request->all());
        $user->save();
        flash()->success(__('The Changes have been saved!'));

        return back();
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
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
