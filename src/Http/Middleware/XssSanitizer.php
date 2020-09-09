<?php

namespace LaravelEnso\Core\Http\Middleware;

use voku\helper\AntiXSS;

class XssSanitizer
{
    private AntiXSS $antiXss;

    public function __construct(AntiXSS $antiXss)
    {
        $this->antiXss = $antiXss;
    }

    public function handle($request, $next, ...$fields)
    {
        $request->merge($this->clean($request->all($fields)));

        return $next($request);
    }

    private function clean($input)
    {
        return $this->antiXss->removeEvilAttributes(['style'])
            ->xss_clean($input);
    }
}
