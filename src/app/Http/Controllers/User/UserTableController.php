<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\VueDatatable\app\Traits\Datatable;
use LaravelEnso\VueDatatable\app\Traits\Excel;

class UserTableController extends Controller
{
    use Datatable, Excel;

    private const Template = __DIR__.'/../../../Tables/users.json';

    public function query()
    {
        return User::select(\DB::raw(
            'users.id as dtRowId, owners.name owner, users.first_name, users.last_name, users.phone,
            users.email, roles.name role, users.is_active'
            ))->join('owners', 'users.owner_id', '=', 'owners.id')
            ->join('roles', 'users.role_id', '=', 'roles.id');
    }
}
