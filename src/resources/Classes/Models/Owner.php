<?php

namespace App;

use LaravelEnso\Core\App\Models\Owner as Owners;

class Owner extends Owners
{
    protected $fillable = [
        'name', 'is_active',
    ];
}
