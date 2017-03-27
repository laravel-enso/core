<?php

namespace LaravelEnso\Core\app\Http\Middleware;

use App;
use Closure;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::setLocale(request()->user()->language);

        return $next($request);
    }
}
