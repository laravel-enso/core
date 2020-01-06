<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;

class Authentication extends AuthenticationException
{
    public static function expiredPassword()
    {
        return new self(__(
            'Your password has expired. Please use the reset password form to set a new one'
        ));
    }

    public static function disabledAccount()
    {
        return new self(__(
            'Your account has been disabled. Please contact the administrator'
        ));
    }
}
