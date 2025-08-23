<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | Store credentials for third party services like Mailgun, Postmark, AWS, etc.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Health Monitor (custom)
    |--------------------------------------------------------------------------
    */

    // Protects the REST endpoints with X-API-Key
    'health' => [
        'key' => env('HEALTH_API_KEY', 'changeme'),
    ],

    // Slack webhook used by RunServiceCheck notifications (incident open/resolve)
    'alerts' => [
        'slack_webhook' => env('ALERT_SLACK_WEBHOOK'),
    ],

];
