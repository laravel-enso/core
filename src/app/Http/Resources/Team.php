<?php

namespace LaravelEnso\Core\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'userIds' => $this->whenLoaded('users', $this->userIds()),
            'users' => $this->whenLoaded('users', $this->userList()),
            'edit' => false,
        ];
    }
}
