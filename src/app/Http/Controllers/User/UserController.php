<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Core\app\Http\Services\UserService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use LaravelEnso\Core\app\Http\Requests\ValidateUserRequest;

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        return $this->service->create();
    }

    public function store(ValidateUserRequest $request, User $user)
    {
        $response = $this->service->store($request, $user);
        $this->sendResetLinkEmail($request);

        return $response;
    }

    public function show(User $user)
    {
        return $this->service->show($user);
    }

    public function edit(User $user)
    {
        return $this->service->edit($user);
    }

    public function update(ValidateUserRequest $request, User $user)
    {
        return $this->service->update($request, $user);
    }

    public function destroy(User $user)
    {
        return $this->service->destroy($user);
    }
}
