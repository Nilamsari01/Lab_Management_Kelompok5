<?php

// config/services.php - tambahkan di dalam array 'return'

return [
    // ... konfigurasi lainnya

    'external_api' => [
        'base_url' => env('EXTERNAL_API_BASE_URL', 'https://api.example.com'),
        'api_key' => env('EXTERNAL_API_KEY'),
        'timeout' => env('EXTERNAL_API_TIMEOUT', 30),
    ],
];
