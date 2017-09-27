<?php

namespace LaravelEnso\Core\app\Exceptions;

use Exception;

class EnsoException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct(__($message), 455);
    }

    public function render()
    {
        return response()->json([
            'message'  => $this->getMessage(),
        ], $this->getCode());
    }
}