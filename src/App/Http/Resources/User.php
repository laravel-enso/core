<?php

namespace LaravelEnso\Core\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\Avatars\App\Http\Resources\Avatar;
use LaravelEnso\People\App\Http\Resources\Person;
use LaravelEnso\Roles\App\Http\Resources\Role;

class User extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'isActive' => $this->is_active,
            'email' => $this->email,
            'person' => new Person($this->whenLoaded('person')),
            'avatar' => new Avatar($this->whenLoaded('avatar')),
            'role' => new Role($this->whenLoaded('role')),
            'group' => new Group($this->whenLoaded('group')),
        ];
    }
}
