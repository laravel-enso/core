<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use App\User;
use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Classes\ProfileBuilder;
use LaravelEnso\Core\app\Forms\Builders\UserForm;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use LaravelEnso\Core\app\Http\Requests\ValidateUserRequest;

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    public function create(UserForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateUserRequest $request)
    {
        $user = new User($request->validated());

        $this->authorize('handle', $user);

        $user->save();

        $this->sendResetLinkEmail($request);

        return [
            'message' => __('The user was successfully created'),
            'redirect' => 'administration.users.edit',
            'id' => $user->id,
        ];
    }

    public function show(User $user)
    {
        (new ProfileBuilder($user))->set();

        return ['user' => $user];
    }

    public function edit(User $user, UserForm $form)
    {
        return ['form' => $form->edit($user)];
    }

    public function update(ValidateUserRequest $request, User $user)
    {
        $this->authorize('handle', $user);

        if ($request->filled('password')) {
            $this->authorize('change-password', $user);
            $user->password = bcrypt($request->get('password'));
        }

        if ($request->get('role_id') !== $user->role_id) {
            $this->authorize('change-role', $user);
        }

        $user->update($request->validated());

        return ['message' => __('The user was successfully updated')];
    }

    public function destroy(User $user)
    {
        $this->authorize('handle', $user);

        $user->delete();

        return [
            'message' => __('The user was successfully deleted'),
            'redirect' => 'administration.users.index',
        ];
    }
}
