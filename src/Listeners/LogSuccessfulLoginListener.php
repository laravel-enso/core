<?php

namespace LaravelEnso\Core\Listeners;

use LaravelEnso\Core\Models\Login;

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
     * @param  Login  $event
     * @return void
     */
    public function handle()
    {
        $login = new Login([
            'user_id' => \Auth::user()->id,
            'ip'      => request()->ip(),
        ]);

        $login->save();
    }
}
