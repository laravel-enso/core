<?php

namespace LaravelEnso\Core\app\Classes;

use App\User;
use LaravelEnso\Core\app\Models\Team;

class TeamMemberChanges
{
    private $team;
    private $synced;
    private $message = null;

    public function __construct(Team $team, array $synced)
    {
        $this->team = $team;
        $this->synced = $synced;
    }

    public function log()
    {
        if (count($this->synced['attached'])) {
            $this->computeAttached();
        }

        if (count($this->synced['detached'])) {
            $this->computeDetached();
        }

        if ($this->message) {
            $this->team->logEvent($this->message, 'users');
        }
    }

    private function computeAttached()
    {
        $attached = $this->users($this->synced['attached']);

        $this->message = 'added the user(s): '.$attached;
    }

    private function computeDetached()
    {
        $detached = $this->users($this->synced['detached']);

        if ($this->message) {
            $this->message .= ' and ';
        }

        $this->message .= 'removed the user(s): '.$detached;
    }

    private function users($ids)
    {
        return User::whereIn('id', $ids)
            ->get()
            ->pluck('fullName')
            ->implode(', ');
    }
}
