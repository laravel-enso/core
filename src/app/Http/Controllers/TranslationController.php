<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;

class TranslationController extends Controller
{
    public function __invoke()
    {
        if (empty(request()->all())) {
            return [];
        }

        $translations = [];

        foreach (request()->all() as $key) {
            $translations[$key] = __($key);
        }

        return $translations;
    }
}
