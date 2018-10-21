<?php

namespace LaravelEnso\Core\app\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class UserSelectController extends Controller
{
    use OptionsBuilder;

    protected $queryAttributes = [
        'email', 'person.name', 'person.appellative'
    ];

    public function query()
    {
        return User::active()
            ->with([
                'person:id,appellative,name',
                'avatar:id,user_id',
            ]);
    }
}
