<?php

namespace LaravelEnso\Core\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Inspiring
{
    public static function quote(): string
    {
        $quotes = Config::get('enso.inspiring.quotes');

        return Collection::wrap($quotes)->random();
    }
}
