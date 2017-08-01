<?php

namespace LaravelEnso\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;

class TranslationController extends Controller
{
    public function __invoke()
    {
        return collect(request()->all())->reduce(function ($trans, $label) {
            $trans[$label] = __($label);

            return $trans;
        });
    }
}
