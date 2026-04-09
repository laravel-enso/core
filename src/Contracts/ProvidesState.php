<?php

namespace LaravelEnso\Core\Contracts;

interface ProvidesState
{
    public function store(): string;

    public function state(): array;
}
