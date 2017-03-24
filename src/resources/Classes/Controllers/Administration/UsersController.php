<?php

namespace App\Http\Controllers\Administration;

use App\DataTable\UsersTableStructure;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateUserRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use LaravelEnso\ActionLogger\App\Models\ActionsHistory;
use LaravelEnso\Core\App\Models\Owner;
use LaravelEnso\Core\App\Models\User;
use LaravelEnso\DataTable\App\Traits\DataTable;
use LaravelEnso\DataTable\App\Traits\DataTableEditor;

class UsersController extends Controller
{
    use SendsPasswordResetEmails, DataTable, DataTableEditor;

    protected $tableStructureClass = UsersTableStructure::class;

    public static function getTableQuery()
    {
        $id = request()->user()->owner_id === 1 ?: 2;

        $query = User::select(\DB::raw('users.id as DT_RowId, owners.name owner, users.first_name, users.last_name, users.nin, users.phone, users.email, roles.name role, users.is_active'))
            ->join('owners', 'users.owner_id', '=', 'owners.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('owner_id', '>=', $id);

        return $query;
    }

    public function index()
    {
        return view('laravel-enso/core::pages.administration.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();

        $roles = [];

        $id = request()->user()->owner->id === 1 ?: 2;
        $owners = Owner::where('id', '>=', $id)->active()->get()->pluck('name', 'id');

        return view('laravel-enso/core::pages.administration.users.create', compact('owners', 'user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValidateUserRequest|Request $request
     * @param User                        $user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateUserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->email = $request->email;
        $user->owner_id = $request->owner_id;
        $user->save();

        flash()->success(__('The User was created!'));

        $this->sendResetLinkEmail($request);

        return redirect('administration/users/'.$user->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function show(User $user)
    {
        $user->load('owner')
            ->load('role')
            ->load('avatar');

        $timeline = ActionsHistory::whereUserId($user->id)->latest()->limit(10)->get();

        return view('laravel-enso/core::pages.administration.users.show', compact('user', 'timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function edit(User $user)
    {
        $user->load('owner')
            ->load('role');

        // excluding "Admin" Owner for Users that do not belong to 'Admin'
        $id = request()->user()->owner->id === 1 ?: 2;
        $owners = Owner::where('id', '>=', $id)->active()->get()->pluck('name', 'id');

        $roles = $user->owner->roles->pluck('name', 'id');

        return view('laravel-enso/core::pages.administration.users.edit', compact('user', 'roles', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValidateUserRequest|Request $request
     * @param User                        $user
     *
     * @return \Illuminate\Http\Response
     *
     * @internal param int $id
     */
    public function update(ValidateUserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $exception) {
            $response = [
                'level'   => 'error',
                'message' => __('An error has occured. Please report this to the administrator'),
            ];
        }
        if (!isset($response)) {
            $response = [
                'level'   => 'success',
                'message' => __('Operation was successfull'),
            ];
        }

        return $response;
    }

    public function impersonate($id)
    {
        $user = User::find($id);

        \Auth::user()->setImpersonating($user->id);
        flash()->warning(__('Impersonating').' '.$user->full_name);

        return redirect()->back();
    }

    public function stopImpersonating()
    {
        \Auth::user()->stopImpersonating();

        flash()->success(__('Welcome Back'));

        return redirect()->back();
    }
}
