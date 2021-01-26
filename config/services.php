<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'guzzle' => [
        'base_url' => env('GUZZLE_BASE_URL', null),
    ],

    'passport' => [
        'login_endpoint' => env('PASSPORT_LOGIN_ENDPOINT'),
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
    ],

    'allowed_file_extensions' => [
        'images' => env('ALLOWED_IMAGE_EXT', ''),
        'files' => env('ALLOWED_FILE_EXT', ''),
    ],

    'exchange_rate' => [
        'endpoint' => env('RATE_EXCHANGE_ENDPOINT', ''),
        'version' => env('RATE_EXCHANGE_VERSION', ''),
        'api_key' => env('RATE_EXCHANGE_API_KEY', ''),
    ],

    'unifonic' => [
        'app_id' => env('UNIFONIC_APP_ID'),
        'sender_id' => env('UNIFONIC_SENDER_ID'), // String, Optional
        'account_email' => env('UNIFONIC_ACCOUNT_EMAIL'),
        'account_password' => env('UNIFONIC_ACCOUNT_PASSWORD')
    ],

    'google_map' => [
        'key' => env('GOOGLE_MAP_API_KEY', ''),
    ],

    'mapbox' => [
        'access_token' => env('MAPBOX_ACCESS_TOKEN', ''),
    ],

    'paging' => [
        'per_page' => env('ITEM_PER_PAGE', 10),
    ],
];
