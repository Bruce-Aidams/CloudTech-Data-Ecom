<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paystack API Keys
    |--------------------------------------------------------------------------
    |
    | Your Paystack public and secret keys. Use test keys for development
    | and live keys for production. Never commit live keys to version control.
    |
    */

    'public_key' => env('PAYSTACK_PUBLIC_KEY'),
    'secret_key' => env('PAYSTACK_SECRET_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Paystack API URL
    |--------------------------------------------------------------------------
    |
    | The base URL for Paystack API. This should always be the production URL.
    |
    */

    'api_url' => env('PAYSTACK_API_URL', 'https://api.paystack.co'),

    /*
    |--------------------------------------------------------------------------
    | Paystack Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for transactions. Ghana Cedis (GHS) by default.
    |
    */

    'currency' => env('PAYSTACK_CURRENCY', 'GHS'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Request Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout in seconds for HTTP requests to Paystack API.
    |
    */

    'timeout' => env('PAYSTACK_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Webhook URL should be set in your Paystack dashboard.
    | Format: https://yourdomain.com/api/paystack/webhook
    |
    */

    'webhook_url' => env('PAYSTACK_WEBHOOK_URL'),

];
