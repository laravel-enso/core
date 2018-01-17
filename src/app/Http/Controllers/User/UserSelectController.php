<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Select\app\Traits\OptionsBuilder;

class UserSelectController extends Controller
{
    use OptionsBuilder;

    protected $class = User::class;

    protected $queryAttributes = ['first_name', 'last_name', 'email', 'phone'];

    protected $label = 'fullName';
}
