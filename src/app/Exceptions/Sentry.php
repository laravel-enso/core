<?php

namespace LaravelEnso\Core\App\Exceptions;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Throwable;

class Sentry
{
    private const Key = 'sentry-events';

    public static function report(Throwable $exception): void
    {
        if (Auth::check()) {
            self::addContext();
        }

        App::make('sentry')->captureException($exception);

        if (Auth::check()) {
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
}
