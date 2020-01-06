<?php

namespace LaravelEnso\Core\App\Exceptions;

class UserGroupConflict
{
    public static function hasUsers()
    {
        return new self(__(
            "The user group has users attached and can't be deleted
        "));
    }
}
