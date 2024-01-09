<?php

namespace LaravelEnso\Core\Rules;

use Illuminate\Contracts\Validation\Rule;
use LaravelEnso\Users\Models\User;

class DistinctPassword implements Rule
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value)
    {
        return !$value || !$this->user->currentPasswordIs($value);
    }

    public function message()
    {
        return __('You cannot use the existing password');
    }
}
