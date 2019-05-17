<?php

namespace LaravelEnso\Core\app\Http\Requests;

class ValidateUserUpdate extends ValidateUserStore
{
    protected function emailUnique()
    {
        return parent::emailUnique()
            ->ignore($this->route('user')->id);
    }
}
