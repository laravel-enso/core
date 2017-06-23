<?php

    return [
        'defaultRole' => 'admin',
        'formattedTimestamps' => 'd-m-Y',
        'paths'       => [
            'files'    => 'files',
            'avatars'  => 'avatars',
            'imports'  => 'imports',
            'temp'     => 'temp',
            'exports'  => 'exports',
        ],
        'cacheLifetime'   => env('CACHE_LIFETIME', 60)
    ];