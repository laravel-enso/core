<?php

namespace LaravelEnso\Core\app\Classes;

class Inspiring
{
    public static function quote()
    {
        return collect(config('enso.inspiring.quotes'))
            ->random();
    }
}
