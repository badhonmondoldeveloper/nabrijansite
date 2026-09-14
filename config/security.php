<?php

return [
    'session_lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 7200),
    'session_secure' => filter_var($_ENV['SESSION_SECURE'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'csrf_token_key' => '_csrf_token',
    'allowed_image_mimes' => [
        'image/jpeg',
        'image/png',
        'image/webp'
    ],
    'allowed_image_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
];
