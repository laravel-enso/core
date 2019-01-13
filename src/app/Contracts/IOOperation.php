<?php

namespace LaravelEnso\Core\app\Contracts;

interface IOOperation
{
    public function createdBy();

    public function name();

    public function type();

    public function entries();
}
