<?php

namespace LaravelEnso\Core\app\Services;

class Inspiring
{
    public static function quote()
    {
        return collect(config('enso.inspiring.quotes'))->random();
    }
}
