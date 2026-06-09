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

    // Shared secret for the Telegram bot ↔ API trusted channel.
    'telegram_bot' => [
        'secret' => env('BOT_API_SECRET'),
    ],

    // 3X-UI panel (Xray / VLESS-Reality) for real connection provisioning.
    // When disabled, the app provisions demo connections locally.
    'xui' => [
        'enabled' => env('XUI_ENABLED', false),
        'base_url' => env('XUI_BASE_URL'),          // e.g. https://panel.example.com:2053/secretpath
        'token' => env('XUI_API_TOKEN'),            // Settings → Security → API Token
        'inbound_id' => env('XUI_INBOUND_ID'),      // inbound to attach new clients to
        'sub_url_base' => env('XUI_SUB_URL_BASE'),  // e.g. https://sub.example.com:2096/sub
        'verify_tls' => env('XUI_VERIFY_TLS', false),
        'default_bytes' => env('XUI_DEFAULT_BYTES', 0), // traffic quota in bytes; 0 = unlimited
    ],

];
