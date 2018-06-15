<?php

return [
    'version' => '2.x.x',
    'facebook' => '',
    'googleplus' => '',
    'twitter' => 'https://twitter.com',
    'stateBuilder' => '',
    'ownerModel' => 'App\Owner',
    'defaultRole' => 'admin',
    'defaultRole' => 'admin',
    'phpDateFormat' => 'd-m-Y',
    'jsDateFormat' => 'DD-MM-YYYY',
    'paths' => [
        'files' => 'files',
        'avatars' => 'avatars',
        'imports' => 'imports',
        'temp' => 'temp',
        'exports' => 'exports',
        'howToVideos' => 'howToVideos',
    ],
    'ravenKey' => env('RAVEN_DSN', null),
    'cacheLifetime' => env('CACHE_LIFETIME', 60),
    'extendedDocumentTitle' => false,
    'showQuote' => env('SHOW_QUOTE', true),
];
