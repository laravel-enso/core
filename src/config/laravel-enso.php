<?php

return [

    'defaultRole' => 'admin',
    'paths'       => [
        'file'    => 'files',
        'avatars' => 'avatars',
        'imports' => 'imports',
        'temp'    => 'temp',
        'exports' => 'exports',
    ],
    'reportingEmails' => ['aocneanu@gmail.com'],
    'cacheLifetime'   => env('CACHE_LIFETIME', 60),
];
