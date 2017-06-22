<?php

namespace LaravelEnso\Core\app\Listeners;

use LaravelEnso\Core\app\Models\Login;

class LogSuccessfulLoginListener
{
    public function __construct()
    {
        //
    }

    public function handle()
    {
        Login::create([
            'user_id'    => \Auth::user()->id,
            'ip'         => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
