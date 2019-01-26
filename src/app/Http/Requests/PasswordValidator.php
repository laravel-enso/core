<?php

namespace LaravelEnso\Core\app\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class PasswordValidator
{
    private $request;
    private $validator;

    public function __construct(Request $request, Validator $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function handle()
    {
        if ($this->request->filled('password')) {
            if (config('auth.providers.users.model')::query()
                ->whereEmail($this->request->get('email'))
                ->first()->isCurrentPassword($this->request->get('password'))) {
                $this->validator->errors()->add('password', __('You cannot use the existing password'));
            }

            if (! $this->hasMinUppercase()) {
                $this->validator->errors()->add('password', __('Minimum upper case letters count is :number', [
                    'number' => config('enso.config.password.minUpperCase')
                ]));
            }

            if (! $this->hasMinNumeric()) {
                $this->validator->errors()->add('password', __('Minimum numeric characters count is :number', [
                    'number' => config('enso.config.password.minNumeric')
                ]));
            }

            if (! $this->hasMinSpecial()) {
                $this->validator->errors()->add('password', __('Minimum special characters count is :number', [
                    'number' => config('enso.config.password.minSpecial')
                ]));
            }
        }
    }

    private function hasMinUppercase()
    {
        if (! config('enso.config.password.minUpperCase')) {
            return true;
        }

        preg_match('/[A-Z]+/', $this->request->get('password'), $matches);

        return Str::length(collect($matches)->implode(''))
            >= config('enso.config.password.minUpperCase');
    }

    private function hasMinNumeric()
    {
        if (! config('enso.config.password.minNumeric')) {
            return true;
        }

        preg_match('/[0-9]+/', $this->request->get('password'), $matches);

        return Str::length(collect($matches)->implode(''))
            >= config('enso.config.password.minNumeric');
    }

    private function hasMinSpecial()
    {
        if (! config('enso.config.password.minSpecial')) {
            return true;
        }

        preg_match('/[^\da-zA-Z]/', $this->request->get('password'), $matches);

        return Str::length(collect($matches)->implode(''))
            >= config('enso.config.password.minSpecial');
    }
}
