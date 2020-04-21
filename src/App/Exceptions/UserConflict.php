<?php

namespace LaravelEnso\Core\App\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserConflict extends ConflictHttpException
{
    public static function hasActivity()
    {
        return new self(__(
            'The user has activity in the system and cannot be deleted'
        ));
    }
}
