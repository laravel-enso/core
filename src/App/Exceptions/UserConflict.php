<?php

namespace LaravelEnso\Core\App\Exceptions;

class UserConflict
{
    public static function hasActivity()
    {
        return new self(__(
            'The user has activity in the system and cannot be deleted'
        ));
    }
}
