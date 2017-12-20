<?php

namespace LaravelEnso\Core\app\Http\Services;

use Illuminate\Http\Request;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Classes\UserProfile;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserService
{
    const FormPath = __DIR__.'/../../Forms/user.json';

    public function create()
    {
        $form = (new FormBuilder(self::FormPath))
            ->setTitle('Create User')
            ->setMethod('POST')
            ->getData();

        return compact('form');
    }

    public function store(Request $request, User $user)
    {
        \DB::transaction(function () use ($request, &$user) {
            $user->fill($request->all());
            $user->email = $request->get('email');
            $user->owner_id = $request->get('owner_id');
            $user->role_id = $request->get('role_id');
            $user->save();
        });

        return [
            'message' => __('The user was created!'),
            'redirect' => 'administration.users.edit',
            'id' => $user->id,
        ];
    }

    public function show(User $user)
    {
        $profile = new UserProfile($user);

        return ['user' => $profile->get()];
    }

    public function edit(User $user)
    {
        $form = (new FormBuilder(self::FormPath, $user))
            ->setTitle('Edit User')
            ->setMethod('PATCH')
            ->getData();

        return compact('form');
    }

    public function update(Request $request, User $user)
    {
        $user->fill($request->all());
        $user->email = $request->get('email');
        $user->owner_id = $request->get('owner_id');
        $user->role_id = $request->get('role_id');
        $user->save();

        return [
            'message' => __(config('enso.labels.savedChanges')),
        ];
    }

    public function destroy(User $user)
    {
        if ($user->logins->first()) {
            throw new ConflictHttpException(__('The user has activity in the system and cannot be deleted'));
        }

        $user->delete();

        return [
            'message' => __(config('enso.labels.successfulOperation')),
            'redirect' => 'administration.users.index',
        ];
    }
}
