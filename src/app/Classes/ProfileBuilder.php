<?php

namespace LaravelEnso\Core\app\Classes;

use Carbon\Carbon;
use App\User;

class ProfileBuilder
{
    private const LoginsRating = 80;
    private const ActionsRating = 20;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function set()
    {
        $this->user->load(['owner', 'role', 'avatar']);

        $this->build();
    }

    public function build()
    {
        $this->user->load(['owner', 'role']);
        $this->user->loginCount = $this->user->logins()->count();
        $this->user->actionLogCount = $this->user->actionLogs()->count();
        $this->user->daysSinceMember = Carbon::parse($this->user->created_at)->diffInDays() ?: 1;
        $this->user->rating = $this->rating();
    }

    private function rating()
    {
        return intval(
            (self::LoginsRating * $this->user->loginCount / $this->user->daysSinceMember +
            self::ActionsRating * $this->user->actionLogCount / $this->user->daysSinceMember) / 100
        );
    }
}
