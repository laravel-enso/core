<?php

namespace LaravelEnso\Core\app\Exceptions;

use Exception;

class EnsoException extends Exception
{
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct(__($message), $code);
    }

    public function render()
    {
        return response()->json([
            'message'  => $this->getMessage(),
        ], $this->getCode());
    }
}
