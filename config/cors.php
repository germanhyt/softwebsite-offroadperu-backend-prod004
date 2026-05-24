<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        // Acceso temporal por IP (VPS) hasta configurar DNS
        'http://2.24.123.124:8082',
        'http://2.24.123.124:8081',
        'https://offroadperu.com.pe',
        'https://www.offroadperu.com.pe',
        'https://admin.offroadperu.com.pe',
    ],

    'allowed_origins_patterns' => [
        '/^https:\/\/([a-z0-9-]+\.)?offroadperu\.com\.pe$/i',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
