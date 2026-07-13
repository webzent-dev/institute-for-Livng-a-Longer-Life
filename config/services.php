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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'zoom' => [
        'account_id'    => env('ZOOM_ACCOUNT_ID'),
        'client_id'     => env('ZOOM_CLIENT_ID'),
        'client_secret' => env('ZOOM_CLIENT_SECRET'),
        // ZoomService builds paths as "{base_url}/users/...", so the trailing slash
        // in ZOOM_API_URL must be trimmed or every request gets a doubled slash.
        'base_url'      => rtrim(env('ZOOM_API_URL', 'https://api.zoom.us/v2'), '/'),
    ],

    'stripe' => [
        'key'            => env('STRIPE_KEY'),
        'secret'         => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'mode'           => env('STRIPE_MODE', 'live'),
    ],

    'shopify_app' => [
        'api_key' => env('SHOPIFY_APP_API_KEY'),
        'base_url' => env('SHOPIFY_APP_URL'),
        'webhook_secret' => env('SHOPIFY_APP_WEBHOOK_SECRET'),
    ],

    'standard_process' => [
        'store_url' => env('STANDARD_PROCESS_STORE_URL'),
    ],

];
