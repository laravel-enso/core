<?php

namespace LaravelEnso\Core\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserGroupConflict extends ConflictHttpException
{
    public static function hasUsers()
    {
        return new self(__(
            "The user group has users attached and can't be deleted
        "));
    }
}
