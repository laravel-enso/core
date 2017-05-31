<?php

namespace LaravelEnso\Core\app\Listeners;

use LaravelEnso\Core\app\Models\Login;

class LogSuccessfulLoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     *
     * @return void
     */
    public function handle()
    {
        $login = new Login([

            'user_id'    => \Auth::user()->id,
            'ip'         => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);

        $login->save();
    }
}
