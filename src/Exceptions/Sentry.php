<?php

namespace LaravelEnso\Core\Exceptions;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use RedisException;
use Throwable;

class Sentry
{
    private const Key = 'sentry-events';

    public static function report(Throwable $exception): void
    {
        if (self::shouldSkip($exception)) {
            return;
        }

        if (Auth::check()) {
            self::addContext();
        }

        App::make('sentry')->captureException($exception);

        if (Auth::check() && App::isProduction()) {
            self::storeEventId();
        }
    }

    public static function eventId(): ?string
    {
        $events = Cache::get(self::Key);
        $eventId = $events[Auth::user()->id] ?? null;

        return $eventId;
    }

    private static function storeEventId(): void
    {
        $events = Cache::get(self::Key, []);
        $events[Auth::user()->id] = App::make('sentry')->getLastEventId();

        Cache::forever(self::Key, $events);
    }

    private static function addContext(): void
    {
        App::make('sentry')->configureScope(fn ($scope) => $scope->setUser([
            'id' => Auth::user()->id,
            'username' => Auth::user()->person->name,
            'email' => Auth::user()->email,
        ])->setExtra('role', Auth::user()->role->name));
    }

    private static function shouldSkip(Throwable $exception): bool
    {
        $key = Str::of($exception::class)->snake()->slug()
            ->append(':', Str::of($exception->getMessage())->snake()->slug())
            ->__toString();

        $store = $exception instanceof RedisException ? 'file' : null;

        $cache = Cache::store($store);

        if ($cache->has($key)) {
            return true;
        }

        $cache->put($key, true, Carbon::now()->addMinutes(5));

        return false;
    }
}
