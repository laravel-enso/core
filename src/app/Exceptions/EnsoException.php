<?php

namespace LaravelEnso\Core\app\Exceptions;

use Exception;

class EnsoException extends Exception
{
    private $level;

    public function __construct(string $message, string $level = 'error', array $errorBag = [], int $code = 400)
    {
        $this->level = $level;
        $this->errorBag = $errorBag;
        parent::__construct(__($message), $code);
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getErrorBag()
    {
        return $this->errorBag;
    }
}
