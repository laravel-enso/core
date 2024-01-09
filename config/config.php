<?php

return [
    'version'               => '4.8.0',
    'ownerCompanyId'        => env('OWNER_COMPANY_ID', 1),
    'showQuote'             => env('SHOW_QUOTE', true),
    'defaultRole'           => 'admin',
    'dateFormat'            => 'd-m-Y',
    'dateTimeFormat'        => 'd-m-Y H:i:s',
    'facebook'              => 'https://facebook.com',
    'instagram'             => 'https://www.instagram.com',
    'twitter'               => 'https://twitter.com',
    'tiktok'                => 'https://tiktok.com',
    'extendedDocumentTitle' => env('EXTENDED_DOCUMENT_TITLE', true),
];
