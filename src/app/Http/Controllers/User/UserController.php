<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use LaravelEnso\Core\app\Http\Requests\ValidateUserRequest;
use LaravelEnso\Core\app\Http\Services\UserService;
use LaravelEnso\Core\app\Models\User;

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    private $users;

    public function __construct(Request $request)
    {
        $this->users = new UserService($request);
    }

    public function index()
    {
        return view('laravel-enso/core::administration.users.index');
    }

    public function create()
    {
        return $this->users->create();
    }

    public function store(ValidateUserRequest $request, User $user)
    {
        $response = $this->users->store($user);
        $this->sendResetLinkEmail($request);

        return $response;
    }

    public function show(User $user)
    {
        return $this->users->show($user);
    }

    public function edit(User $user)
    {
        return $this->users->edit($user);
    }

    public function update(ValidateUserRequest $request, User $user)
    {
        return $this->users->update($user);
    }

    public function destroy(User $user)
    {
        return $this->users->destroy($user);
    }
}
