<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\FormBuilder\app\Classes\Form;
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
        $user = User::create($request->all());

        $this->sendResetLinkEmail($request);

        return [
            'message' => __('The user was created!'),
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
        $user->update($request->all());

        return ['message' => __(config('enso.labels.savedChanges'))];
    }

    public function destroy(User $user)
    {
        $user->delete();

        return [
            'message' => __(config('enso.labels.successfulOperation')),
            'redirect' => 'administration.users.index',
        ];
    }
}
