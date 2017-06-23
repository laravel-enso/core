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
        if (request()->ajax()) {
            return response()->json([
                'level' => $this->exception->getLevel(),
                'message' => $this->exception->getMessage()
            ], $this->exception->getCode());
        }

        flash()->{$this->exception->getLevel()}($this->exception->getMessage());

        return back();
    }
}