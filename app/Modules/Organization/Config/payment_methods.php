<?php

return [
    'stripe' => [
        'required_settings' => ['api_key', 'secret_key'],
    ],
    'paypal' => [
        'required_settings' => ['client_id', 'client_secret'],
    ],
    'cod' => [
        'required_settings' => [],
    ],
    'bank_transfer' => [
        'required_settings' => ['account_number', 'iban', 'swift_code'],
    ],
    'apple_pay' => [
        'required_settings' => ['merchant_id', 'key_id', 'private_key'],
    ],
    'google_pay' => [
        'required_settings' => ['merchant_id', 'gateway_key'],
    ],
    'vodafone_cash' => [
        'required_settings' => ['phone_number', 'reference_code'],
    ],
    'instapay' => [
        'required_settings' => ['instapay_id'],
    ],
    'visa' => [
        'required_settings' => ['api_key', 'secret_key'],
    ],
    'mastercard' => [
        'required_settings' => ['api_key', 'secret_key'],
    ],
    'mada' => [
        'required_settings' => ['api_key', 'secret_key', 'merchant_id'],
    ],
    'fawry' => [
        'required_settings' => ['merchant_code', 'security_key'],
    ],
    'tabby' => [
        'required_settings' => ['public_key', 'secret_key'],
    ],
    'moyasar' => [
        'required_settings' => ['api_key', 'publishable_api_key'],
    ],
    'paymob' => [
        'required_settings' => ['api_key', 'hmac_secret', 'merchant_id'],
    ],
];
