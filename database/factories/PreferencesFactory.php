<?php

namespace LaravelEnso\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Core\Models\Preferences;
use LaravelEnso\Users\Models\User;

class PreferencesFactory extends Factory
{
    protected $model = Preferences::class;

    public function forUser(User $user)
    {
        return $this->state(['user_id' => $user->id]);
    }

    public function definition(): array
    {
        return [
            'value' => [
                'global' => [
                    'lang'            => 'en',
                    'dtStateSave'     => true,
                    'expandedSidebar' => true,
                    'bookmarks'       => true,
                    'theme'           => 'light',
                    'toastrPosition'  => 'bottom-right',
                ],
                'local' => [],
            ],
        ];
    }
}
