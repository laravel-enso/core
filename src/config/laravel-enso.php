<?php

    return [
        'version'             => '1.3.19',
        'defaultRole'         => 'admin',
        'defaultRole'         => 'admin',
        'formattedTimestamps' => 'd-m-Y',
        'paths'               => [
            'files'       => 'files',
            'avatars'     => 'avatars',
            'imports'     => 'imports',
            'temp'        => 'temp',
            'exports'     => 'exports',
            'howToVideos' => 'howToVideos',
        ],
        'sentryRavenKey' => env('SENTRY_RAVEN_DSN', 'no-sentry-raven-key-found-in-env'),
        'cacheLifetime' => env('CACHE_LIFETIME', 60),
    ];
