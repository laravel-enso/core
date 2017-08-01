<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\DataTable\UsersTableStructure;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\DataTable\app\Traits\DataTable;

class UserTableController extends Controller
{
    use DataTable;

    protected $tableStructureClass = UsersTableStructure::class;

    public function getTableQuery()
    {
        return User::select(\DB::raw('users.id as DT_RowId, owners.name owner, users.first_name, users.last_name, users.phone, users.email, roles.name role, users.is_active'))
            ->join('owners', 'users.owner_id', '=', 'owners.id')
            ->join('roles', 'users.role_id', '=', 'roles.id');
    }
}
