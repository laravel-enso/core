<?php

namespace LaravelEnso\Core\app\Http\Controllers\User;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Select\app\Traits\SelectListBuilder;

class UserSelectController extends Controller
{
    use SelectListBuilder;

    protected $selectSourceClass = User::class;
    protected $selectAttributes = ['first_name', 'last_name', 'email', 'phone'];
    protected $displayAttribute = 'fullName';
}
