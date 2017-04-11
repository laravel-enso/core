<?php

namespace LaravelEnso\Core\app\Exceptions;

use Exception;

class EnsoException extends Exception
{
    private $level;

    public function __construct(string $message, string $level = 'error', int $code = 400)
    {
        $this->level = $level;
        parent::__construct(__($message), $code);
    }

    public function getLevel()
    {
        return $this->level;
    }
}
