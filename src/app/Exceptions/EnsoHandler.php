<?php

namespace LaravelEnso\Core\app\Exceptions;

class EnsoHandler
{
    private $exception;

    public function __construct(EnsoException $exception)
    {
        $this->exception = $exception;
    }

    public function render()
    {
        return response()->json([
            'message'  => $this->exception->getMessage(),
        ], $this->exception->getCode());
    }
}
