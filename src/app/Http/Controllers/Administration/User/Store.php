<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LaravelEnso\Core\app\Http\Requests\ValidateUserStore;

class Store extends Controller
{
    use AuthorizesRequests;

    public function __invoke(ValidateUserStore $request, User $user)
    {
        $user->fill($request->validated());

        $this->authorize('handle', $user);

        tap($user)->save()
            ->sendResetPasswordEmail();

        return [
            'message' => __('The user was successfully created'),
            'redirect' => 'administration.users.edit',
            'param' => ['user' => $user->id],
        ];
    }
}
