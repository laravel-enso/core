<?php

namespace LaravelEnso\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Token extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastUsedAt' => $this->last_used_at,
        ];
    }
}
