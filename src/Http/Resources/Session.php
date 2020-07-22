<?php

namespace LaravelEnso\Core\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Session extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ipAddress' => $this->ip_address,
            'name' => $this->name,
            'OS' => $this->agent()->platform(),
            'OSVersion' => $this->agent()->version($this->agent()->platform()),
            'deviceType' => $this->agent()->deviceType(),
            'browser' => $this->agent()->browser(),
            'browserVersion' => $this->agent()->version($this->agent()->browser()),
            'lastActivity' => Carbon::createFromTimestamp($this->last_activity),
        ];
    }
}
