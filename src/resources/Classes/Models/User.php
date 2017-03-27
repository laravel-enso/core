<?php

namespace App;

use LaravelEnso\Core\app\Models\User as Users;

class User extends Users
{
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'is_active', 'role_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar_link', 'full_name'];
}
