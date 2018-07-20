<?php

namespace LaravelEnso\Core\app\Http\Responses;

use LaravelEnso\Core\app\Models\Team;
use Illuminate\Contracts\Support\Responsable;

class TeamIndex implements Responsable
{
    public function toResponse($request)
    {
        return Team::with(['users'])
            ->latest()
            ->get()
            ->each->append('userList');
    }
}
