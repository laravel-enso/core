<?php

namespace LaravelEnso\Core\app\Classes;

use Carbon\Carbon;
use LaravelEnso\ActionLogger\app\Models\ActionLog;
use LaravelEnso\Core\app\Models\User;

class UserProfile
{
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;
		$this->build();
	}

	public function get()
	{
		return $this->user;
	}

	private function build()
	{
		$this->user->load(['owner', 'role', 'avatar']);
        $this->user->loginCount = $this->user->logins()->count();
        $this->user->actionLogCount = $this->user->actionLogs()->count();
        $this->user->daysSinceMember = Carbon::parse($this->user->created_at)->diffInDays() ?: 1;
        $this->user->rating = intval(
            0.8 * $this->user->loginCount / $this->user->daysSinceMember +
            0.2 * $this->user->actionLogCount / $this->user->daysSinceMember
        );

        $this->user->timeline = ActionLog::whereUserId($this->user->id)
            ->whereHas('permission', function($query) {
            	$query->where('name', 'like', '%index')
            		->orWhere('name', 'like', '%create')
            		->orWhere('name', 'like', '%edit')
            		->orWhere('name', 'like', '%destroy');
            })->with('permission')->latest()
            ->paginate(10);
	}
}