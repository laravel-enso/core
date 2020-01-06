<?php

namespace LaravelEnso\Core\App\Events;

use Illuminate\Queue\SerializesModels;
use LaravelEnso\Core\App\Models\User;

class Login
{
    use SerializesModels;

    public User $user;
    public string $ip;
    public string $userAgent;

    public function __construct(User $user, string $ip, string $userAgent)
    {
        $this->user = $user;
        $this->ip = $ip;
        $this->userAgent = $userAgent;
    }
}
