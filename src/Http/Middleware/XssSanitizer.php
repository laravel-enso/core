<?php

namespace LaravelEnso\Core\Http\Middleware;

class XssSanitizer
{
    public function handle($request, $next, ...$fields)
    {
        $request->merge($this->clean($request->all($fields)));

        return $next($request);
    }

    private function clean(mixed $input): mixed
    {
        if (is_array($input)) {
            return array_map(fn (mixed $value): mixed => $this->clean($value), $input);
        }

        if (! is_string($input)) {
            return $input;
        }

        $sanitized = preg_replace('/\sstyle\s*=\s*("|\').*?\1/i', '', $input) ?? $input;
        $sanitized = preg_replace('/\son[a-z]+\s*=\s*("|\').*?\1/i', '', $sanitized) ?? $sanitized;

        return strip_tags($sanitized);
    }
}
