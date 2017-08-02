<?php

namespace LaravelEnso\Core\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\ActionLogger\app\Models\ActionLog;
use LaravelEnso\Core\app\Models\Owner;
use LaravelEnso\Core\app\Models\User;

class UserService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $roles = [];
        $owners = Owner::active()->pluck('name', 'id');

        return view('laravel-enso/core::administration.users.create', compact('owners', 'roles'));
    }

    public function store(User $user)
    {
        \DB::transaction(function () use (&$user) {
            $user->fill($this->request->all());
            $user->email = $this->request->get('email');
            $user->owner_id = $this->request->get('owner_id');
            $user->role_id = $this->request->get('role_id');
            $user->save();
        });

        flash()->success(__('The User was created!'));

        return redirect('administration/users/'.$user->id.'/edit');
    }

    public function show(User $user)
    {
        $user->load(['owner', 'role', 'avatar']);

        $timeline = ActionLog::whereUserId($user->id)
            ->with('permission')
            ->latest()
            ->paginate(7);

        return view('laravel-enso/core::administration.users.show', compact('user', 'timeline'));
    }

    public function edit(User $user)
    {
        $owners = Owner::active()->pluck('name', 'id');
        $roles = $user->owner->roles()->pluck('name', 'id');

        return view('laravel-enso/core::administration.users.edit', compact('user', 'roles', 'owners'));
    }

    public function update(User $user)
    {
        $user->fill($this->request->all());
        $user->email = $this->request->get('email');
        $user->owner_id = $this->request->get('owner_id');
        $user->role_id = $this->request->get('role_id');
        $user->save();
        flash()->success(__(config('labels.savedChanges')));

        return back();
    }

    public function destroy(User $user)
    {
        if ($user->logins->first()) {
            throw new \EnsoException(__('The user has activity in the system and cannot be deleted'));
        }

        $user->delete();

        return ['message' => __(config('labels.successfulOperation'))];
    }
}
