<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use LaravelEnso\Core\app\DataTable\UsersTableStructure;
use LaravelEnso\Core\app\Http\Requests\ValidateUserRequest;
use LaravelEnso\Core\app\Http\Services\UserService;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\DataTable\app\Traits\DataTable;

class UserController extends Controller
{
    use DataTable, SendsPasswordResetEmails;

    private $users;

    protected $tableStructureClass = UsersTableStructure::class;

    public function __construct(Request $request)
    {
        $this->users = new UserService($request);
    }

    public function getTableQuery()
    {
        return $this->users->getTableQuery();
    }

    public function index()
    {
        return $this->users->index();
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
