<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use LaravelEnso\Core\app\Http\Responses\GuestI18n;

class GuestController extends Controller
{
    public function __invoke()
    {
        return [
            'meta' => $this->meta(),
            'i18n' => $this->i18n(),
        ];
    }

    private function meta()
    {
        return [
            'appName' => config('app.name'),
        ];
    }

    private function i18n()
    {
        return new GuestI18n();
    }
}
