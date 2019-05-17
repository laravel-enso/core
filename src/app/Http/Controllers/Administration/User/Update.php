<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LaravelEnso\Core\app\Http\Requests\ValidateUserUpdate;

class Update extends Controller
{
    use AuthorizesRequests;

    public function __invoke(ValidateUserUpdate $request, User $user)
    {
        $this->authorize('handle', $user);

        if ($request->filled('password')) {
            $this->authorize('change-password', $user);
            $user->password = bcrypt($request->get('password'));
        }

        $user->fill($request->validated());

        $this->authorize('update', $user);

        $user->save($request->validated());

        if (collect($user->getChanges())->keys()->contains('password')) {
            event(new PasswordReset($user));
        }

        return ['message' => __('The user was successfully updated')];
    }
}
