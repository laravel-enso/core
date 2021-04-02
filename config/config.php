<?php

use Illuminate\Support\Facades\Config;

return [
    'version' => '4.6.0',
    'ownerCompanyId' => env('OWNER_COMPANY_ID', 1),
    'showQuote' => env('SHOW_QUOTE', true),
    'defaultRole' => 'admin',
    'dateFormat' => 'd-m-Y',
    'dateTimeFormat' => 'd-m-Y H:i:s',
    'url' => config('app.url'),
    'facebook' => 'https://facebook.com',
    'instagram' => 'https://www.instagram.com',
    'googleplus' => 'https://plus.google.com',
    'twitter' => 'https://twitter.com',
    'ravenKey' => env('RAVEN_DSN', null),
    'cacheLifetime' => env('CACHE_LIFETIME', 60),
    'ensoApiToken' => env('ENSO_API_TOKEN', null),
    'extendedDocumentTitle' => env('EXTENDED_DOCUMENT_TITLE', true),
];
