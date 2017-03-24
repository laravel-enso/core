<?php

namespace App;

use LaravelEnso\Core\App\Models\Owner as Owners;

class Owner extends Owners
{
    protected $fillable = [
        'name', 'fiscal_code', 'reg_com_nr', 'city', 'county', 'bank', 'bank_account', 'postal_code', 'contact', 'phone', 'email', 'address', 'is_individual', 'is_active',
    ];
}
