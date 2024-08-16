<?php

return [
    'merchant_id' => env('PAYMATE_MERCHANT_ID'),
    'base_url' => env('PAYMATE_BASE_URL'),
    'merpubkey' => env('PAYMATE_MERPUBKEY'),
    'jwskey' => env('PAYMATE_JWSKEY'),
    'jwekey' => env('PAYMATE_JWEKEY'),
    'callback' => env('PAYMATE_CALLBACKURL'),
    'notifyurl' => env('PAYMATE_NOTIFYURL'),
];
