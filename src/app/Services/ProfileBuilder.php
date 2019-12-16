<?php

namespace LaravelEnso\Core\app\Services;

use Carbon\Carbon;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Helpers\app\Classes\Decimals;

class ProfileBuilder
{
    private const LoginRating = 80; //TODO refactor in config

    private const ActionRating = 20;

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function set()
    {
        $this->user->load(
            'person:id,name,title,appellative,birthday,phone',
            'group:id,name', 'role:id,name', 'avatar:id,user_id'
        );

        $this->build();
    }

    public function build()
    {
        $this->user->loginCount = $this->user->logins()->count();
        $this->user->person->gender = $this->user->person->gender();
        $this->user->actionLogCount = $this->user->actionLogs()->count();
        $this->user->daysSinceMember = max(Carbon::parse($this->user->created_at)->diffInDays(), 1);
        $this->user->rating = $this->rating();
    }

    private function rating()
    {
        $rating = Decimals::div(self::LoginRating * $this->user->loginCount, $this->user->daysSinceMember) +
            Decimals::div(self::ActionRating * $this->user->actionLogCount, $this->user->daysSinceMember);

        return Decimals::div($rating, 100, 0);
    }
}
