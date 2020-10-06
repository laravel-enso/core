<?php

namespace LaravelEnso\Core\Database\Factories;

use LaravelEnso\Core\Models\UserGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGroupFactory extends Factory
{
    protected $model = UserGroup::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
        ];
    }
}
