<?php

namespace LaravelEnso\Core\app\Classes;

use Illuminate\Support\Collection;

class Inspiring
{
    public static function quote()
    {
        return collect(config('inspiring.quotes'))->random();
    }
}
