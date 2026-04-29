<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shipping Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration settings for the split shipping system
    | including handling fees, package templates, and carrier settings.
    |
    */

    'default_handling_fee' => 2.00,

    'institute' => [
        'address_line_1' => env('INSTITUTE_ADDRESS_LINE_1', '123 Institute St'),
        'city' => env('INSTITUTE_CITY', 'New York'),
        'state' => env('INSTITUTE_STATE', 'NY'),
        'zip_code' => env('INSTITUTE_ZIP_CODE', '10001'),
        'country' => env('INSTITUTE_COUNTRY', 'US'),
    ],

    'carriers' => [
        'shippo' => [
            'api_key' => env('SHIPPO_API_KEY'),
            'enabled' => env('SHIPPO_ENABLED', true),
        ],
        'easypost' => [
            'api_key' => env('EASYPOST_API_KEY'),
            'enabled' => env('EASYPOST_ENABLED', false),
        ],
    ],

    'package_templates' => [
        'usps_flat_rate_small' => [
            'name' => 'USPS Small Flat Rate Box',
            'length' => 8.625,
            'width' => 5.375,
            'height' => 1.625,
            'weight_limit' => 70, // ounces
        ],
        'usps_flat_rate_medium' => [
            'name' => 'USPS Medium Flat Rate Box',
            'length' => 11.25,
            'width' => 8.75,
            'height' => 6,
            'weight_limit' => 70, // ounces
        ],
        'usps_flat_rate_large' => [
            'name' => 'USPS Large Flat Rate Box',
            'length' => 12,
            'width' => 12,
            'height' => 5.5,
            'weight_limit' => 70, // ounces
        ],
        'custom_box' => [
            'name' => 'Custom Box',
            'length' => null,
            'width' => null,
            'height' => null,
            'weight_limit' => null,
        ],
    ],

    'validation' => [
        'require_weight' => true,
        'require_dimensions' => false,
        'min_weight' => 0.01, // pounds
        'max_weight' => 150, // pounds
        'min_dimension' => 0.1, // inches
        'max_dimension' => 108, // inches
        'address_validation' => [
            'enabled' => env('ADDRESS_VALIDATION_ENABLED', true),
            'providers' => [
                'google_maps' => [
                    'enabled' => env('GOOGLE_MAPS_VALIDATION_ENABLED', true),
                    'api_key' => env('GOOGLE_MAPS_API_KEY'),
                    'cache_ttl' => 3600, // 1 hour
                    'primary' => true, // Use as primary provider
                ],
                'usps' => [
                    'enabled' => env('USPS_VALIDATION_ENABLED', false), // Disabled by default
                    'user_id' => env('USPS_USER_ID'),
                    'cache_ttl' => 3600, // 1 hour
                    'primary' => false,
                ],
            ],
            'strict_mode' => env('ADDRESS_VALIDATION_STRICT', false), // Block checkout if validation fails
            'show_suggestions' => true, // Show suggested addresses if validation fails
            'fallback_to_google' => true, // Use Google Maps if primary fails
        ],
    ],

    'rates' => [
        'mock_rates' => [
            'standard' => [
                'base_rate' => 5.99,
                'weight_surcharge_per_pound' => 0.50,
                'estimated_days' => 3,
            ],
            'express' => [
                'base_rate' => 12.99,
                'weight_surcharge_per_pound' => 0.75,
                'estimated_days' => 2,
            ],
            'overnight' => [
                'base_rate' => 24.99,
                'weight_surcharge_per_pound' => 1.00,
                'estimated_days' => 1,
            ],
        ],
    ],
];
