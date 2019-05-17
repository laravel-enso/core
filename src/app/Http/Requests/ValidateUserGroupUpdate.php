<?php

namespace LaravelEnso\Core\app\Http\Requests;

class ValidateUserGroupUpdate extends ValidateUserGroupStore
{
    protected function nameUnique()
    {
        return parent::nameUnique()
            ->ignore($this->route('userGroup')->id);
    }
}
