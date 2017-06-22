<?php

namespace LaravelEnso\Core\app\Listeners;

use LaravelEnso\Core\app\Models\Login;

class LogSuccessfulLoginListener
{
    private $login;

    public function __construct()
    {
        $this->login = new Login();
    }

    public function handle()
    {
        $this->login->create([
            'user_id'    => \Auth::user()->id,
            'ip'         => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
